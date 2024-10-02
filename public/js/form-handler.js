$(document).ready(function() {
    // Setup global CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Función para editar
    function handleEdit(buttonClass, formSelector, updateUrlBase, fieldMap) {
        $('body').on('click', buttonClass, function(e) {
            e.preventDefault();
            const itemId = $(this).data('id');

            $.ajax({
                url: `${updateUrlBase}/${itemId}/edit`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // Iterar sobre el mapeo de campos y actualizar los inputs
                    for (const [fieldName, fieldSelector] of Object.entries(fieldMap)) {
                        const field = $(formSelector).find(fieldSelector);
                        console.log(formSelector);
                        // Verificar si el campo existe antes de intentar actualizarlo
                        if (field.length) {
                            field.val(data[fieldName] || '');
                        }
                    }

                    // Esconder los botones actualizar y cancelar, mostrar guardar
                    $(`${formSelector} #submitButton`).hide();
                    $(`${formSelector} #updateButton`).show();
                    $(`${formSelector} #cancelButton`).show();

                    $(formSelector).attr('action', `${updateUrlBase}/${data.id}`);
                },
                error: function(xhr, status, error) {
                    console.error(`Error fetching data: ${error}`);
                }
            });
        });
    }

    // Función para botón actualizar
function handleUpdate(updateButtonId, formSelector, updateUrlBase) {
    $(updateButtonId).on('click', function(e) {
        e.preventDefault();
        const updateButton = $(this);
        updateButton.prop('disabled', true); // Deshabilita el botón

        const itemId = $(`${formSelector} input[name="id"]`).val();


        $.ajax({
            url: `${updateUrlBase}/${itemId}`,
            method: 'PUT',
            data: $(formSelector).serialize(),
            success: function(response) {
                if(response.code == 404){
                    console.log('Es un error');
                    $('#messageContainer').removeClass('hidden bg-green-500').addClass('bg-red-500 text-white');
                }
                else{
                    $('#messageContainer').removeClass('hidden bg-red-500').addClass('bg-green-500 text-white');
                }
                $('#messageContainer').text(response.message);
                console.log('Clases actuales:', $('#messageContainer').attr('class'));
                setTimeout(function() {
                    location.reload();
                }, 2000); // Opcional: Redirigir después de un tiempo
            },
            error: function(response) {
                const errorCode = response.code; // Código de estado
                console.log(errorCode);
                const errorMessage = response.responseJSON?.message || 'Hubo un error desconocido.';

                $('#messageContainer').text(`Código: ${errorCode}, Mensaje: ${errorMessage}`);
                updateButton.prop('disabled', false);
            },
            complete: function() {
                // Habilitar el botón después de que la solicitud haya terminado
                updateButton.prop('disabled', false);
            }
        });
    });
}


    // Función para botón cancelar
    function handleCancel(cancelButtonId, formSelector, storeUrl) {
        $(cancelButtonId).on('click', function() {
            console.log('Se hizo clic en Cancelar.');

            // Reset form values
            $(formSelector)[0].reset();
            $(`${formSelector} input[name="id"]`).val('');

            // Show submit button, hide update and cancel buttons
            $(`${formSelector} #submitButton`).show();
            $(`${formSelector} #updateButton`).hide();
            $(`${formSelector} #cancelButton`).hide();

            // Reset form action to the store URL
            $(formSelector).attr('action', storeUrl);
        });
    }

    // Ver los mensajes
    function showSuccessMessage() {
        const message = localStorage.getItem('successMessage');
        if (message) {
            $('#messageContainer').text(message)
                .removeClass('hidden')
                .addClass('bg-green-500 text-white');
            setTimeout(function() {
                $('#messageContainer').addClass('hidden');
                localStorage.removeItem('successMessage');
            }, 3000);
        }
    }

    function preventDoubleSubmit(formSelector, submitButtonSelector) {
        const form = document.querySelector(formSelector);
        const submitButton = document.querySelector(submitButtonSelector);
    
        if (form && submitButton) {
            form.addEventListener('submit', function(event) {
                submitButton.disabled = true;
                submitButton.textContent = 'Guardando...';
            });
        }
    }

    //Esportando funciones para ser usadas
    window.preventDoubleSubmit = preventDoubleSubmit;
    window.handleEdit = handleEdit;
    window.handleUpdate = handleUpdate;
    window.handleCancel = handleCancel;
    window.showSuccessMessage = showSuccessMessage;
});