$('document').ready(function () {
    $('#photoform .button_click').on('click', function (e) {
        e.preventDefault();
        $('#photoform-file').trigger('click');
    })

    $('#photoform-file').on('change', function () {
        $('#photoform').submit();
    });

    var genaral_img = $('#modalCrop .image-crop img');
    var k = 0;
    var crop_image = genaral_img.imgAreaSelect({
        aspectRatio: '1:1',
        minHeight: 130,
        minWidth: 130,
        instance: true,
        handles: true,
        fadeSpeed: 200,
        onSelectChange: function () {
            var p = crop_image.getSelection();
            if (k > 0) {
                var k1 = 1/k;
                if (Math.abs(p.x1 - p.x2) < 130) {
                    $('#crop-points').val('');
                } else {
                    $('#crop-points').val(Math.floor(k1*p.x1)+', '+Math.floor(k1*p.y1)+', '+Math.floor(k1*p.x2)+', '+Math.floor(k1*p.y2));
                }
            }
        },
    });

    $('#modalCrop').on('shown.bs.modal', function() {
        k = genaral_img[0].width / genaral_img[0].naturalWidth;
        var p = $('#modalCrop .image-crop').data('points').split(', ').map(Number);
        var dif1 = p[2] - p[0];
        var dif2 = p[3] - p[1];
        if (dif1 !== dif2) {
            var dif3 = dif1 - dif2;
            p[3] += dif3;
        }
        crop_image.setSelection(p[0]*k, p[1]*k, p[2]*k, p[3]*k);
        crop_image.setOptions({ show: true });
        crop_image.update();
    });

    $('#modalCrop').on('hide.bs.modal', function () {
       crop_image.cancelSelection();
        console.log(k);
    });

    $('#modalCrop').scroll(function () {
        crop_image.update();
    });
});
