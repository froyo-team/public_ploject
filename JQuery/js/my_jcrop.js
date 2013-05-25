$(function(){
    var jcrop_api,
        boundx,
        boundy,

        // Grab some information about the preview pane
        $preview = $('#preview-pane'),//预览图片最上层div
        $pcnt = $('#preview-pane .preview-container'),//预览图片所在div的宽度
        $pimg = $('#preview-pane .preview-container img'),//预览图片容器

        xsize = $pcnt.width(),
        ysize = $pcnt.height();

        console.log('init',[xsize,ysize]);
        $('#target').Jcrop({
          onChange: updatePreview,
          onSelect: updateCoords,
          aspectRatio: xsize / ysize
        },function(){
        // Use the API to get the real image size
          var bounds = this.getBounds();
          boundx = bounds[0];
          boundy = bounds[1];
        // Store the API in the jcrop_api variable
          jcrop_api = this;

        // Move the preview into the jcrop container for css positioning
          $preview.appendTo(jcrop_api.ui.holder);
        });


    function updatePreview(c)
    {
      if (parseInt(c.w) > 0)
      {
        var rx = xsize / c.w;
        var ry = ysize / c.h;
        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
      }
    }
  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

    function ajaxFileUpload()
  {
    $.ajaxFileUpload
    (
      {
        url:'../libs/AjaxFileUploaderV2.1/doajaxfileupload.php', 
        secureuri:false,
        fileElementId:'fileToUpload',
        dataType: 'json',
        success: function (data, status)
        {
          if(typeof(data.error) != 'undefined')
          {
            if(data.error != '')
            {
              alert(data.error);
              return false;
            }else
            {
              $('#hidden_img').val(data.image);
              ajaxQrCode();
              return true;
            }
          }
        }
      }
    );
    return true;
  }  
  });