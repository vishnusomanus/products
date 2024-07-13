$(document).ready(function() {
    $('#add-variant').click(function() {
        var index = $('.variant-item').length; 
        var variantHtml = `
            <div class="row variant-item mt-2 mb-2">
                <div class="col-md-4">
                    <input type="text" class="form-control variant-name" name="variant[${index}][name]" placeholder="Variant Name" required>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control variant-values" name="variant[${index}][values]" placeholder="Variant Values (comma-separated)" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-remove-variant">Remove</button>
                </div>
            </div>
        `;
        $('#variant-items').append(variantHtml);
    });

    $('#uploadMainImage').change(function() {
        var formData = new FormData();
        var file = $('#uploadMainImage')[0].files[0];
        formData.append('image', file);

        $.ajax({
            url: "/upload-image",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('.image_grid').prepend('<img src="'+ response.image_url +'" width="75px" class="sel_img active">'); 
                $('.img_thump').html('<img src="'+ response.image_url +'" width="75px" class="">'); 
                $('#main_image').val(response.image_url);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error uploading image. Please try again.');
            }
        });
    });

    $(document).on('click', '.sel_img', function() {
        $('.sel_img').removeClass('active');
        $(this).addClass('active');
        $('#main_image').val($(this).attr('src'));
        $('.img_thump').html('<img src="'+ $(this).attr('src') +'" width="75px" class="">'); 
    });
    
    $(document).on('click', '.btn-remove-variant', function() {
        $(this).closest('.variant-item').remove();
    });

    $('#product-form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);

        var variants = [];
        $('.variant-item').each(function(index) {
            var name = $(this).find('.variant-name').val();
            var values = $(this).find('.variant-values').val().split(',');
            variants.push({
                name: name,
                values: values
            });
        });
        $('#variants_hidden').val(JSON.stringify(variants));
        $(this)[0].submit();
    });

    $(document).on('click', '.btn-danger', function(event) {
        var button = $(this);
        var confirmationMessage = 'Are you sure you want to proceed with this action?';
        
        if (button.hasClass('btn-remove-variant')) {
            confirmationMessage = 'Are you sure you want to remove this variant?';
        }

        if (!confirm(confirmationMessage)) {
            event.preventDefault();
        }
    });
});