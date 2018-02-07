<?php
session_start();
if(isset($_SESSION['login_user']) && empty($_SESSION['login_user'])){

	header("Location: index.php");  
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>jquery.pep droppable w/ consuming parent</title>
  <button onclick="addbox('addbox');">Add box</button>
  <button onclick="SaveBundle();">Save</button>
  <?php
  include 'bgcommerceController.php';
  $res = new bigapi;
  $Bundle = $res->FetchBundle(1);
  ?>
  <!-- Load local jQuery.  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>

  <!-- Load local lib and tests. -->
  <script src="resourses/jquery.pep.js"></script>
  <script type="text/javascript">

    function addbox(type) {

      var randomId = Date.now();
      if(type == 'addbox'){
        $('#dsx').prepend('<div id="' + randomId + '" class="pep context-menu-one btn btn-neutral" style="width: 25px; height: 25px; border: 1px solid #000; z-index: 10;"></div>');
      }
      $(document).ready(function() {

        $('.pep').pep({
          droppable: '.droppable',
          overlapFunction: false,
          useCSSTranslation: false,
          start: function(ev, obj) {
            obj.noCenter = false;
          },
          drag: function(ev, obj) {
            var vel = obj.velocity();
            var rot = (vel.x) / 5;
            rotate(obj.$el, rot);
          },
          stop: function(ev, obj) {
            rotate(obj.$el, 0);
          },
          rest: handleCentering
        });

        function handleCentering(ev, obj) {
          console.log(obj.activeDropRegions.length);
          if (obj.activeDropRegions.length > 0) {
            centerWithin(obj);
          }
        }

        function centerWithin(obj) {
          var $parent = obj.activeDropRegions[0];
          var pTop = $parent.position().top;
          var pLeft = $parent.position().left;
          var pHeight = $parent.outerHeight();
          var pWidth = $parent.outerWidth();

          var oTop = obj.$el.position().top;
          var oLeft = obj.$el.position().left;
          var oHeight = obj.$el.outerHeight();
          var oWidth = obj.$el.outerWidth();

          var cTop = pTop + (pHeight / 2);
          var cLeft = pLeft + (pWidth / 2);

          if (!obj.noCenter) {
            if (!obj.shouldUseCSSTranslation()) {
              var moveTop = cTop - (oHeight / 2);
              var moveLeft = cLeft - (oWidth / 2);
              obj.$el.animate({
                top: moveTop,
                left: moveLeft
              }, 50);
            } else {
              var moveTop = (cTop - oTop) - oHeight / 2;
              var moveLeft = (cLeft - oLeft) - oWidth / 2;
              obj.moveToUsingTransforms(moveTop, moveLeft);
            }

            obj.noCenter = true;
            return;
          }

          obj.noCenter = false;
        }

        function rotate($obj, deg) {
          $obj.css({
            "-webkit-transform": "rotate(" + deg + "deg)",
            "-moz-transform": "rotate(" + deg + "deg)",
            "-ms-transform": "rotate(" + deg + "deg)",
            "-o-transform": "rotate(" + deg + "deg)",
            "transform": "rotate(" + deg + "deg)"
          });
        }

      });

    }

    addbox('editload');
    $("#dsx").click(function(e) {
      alert(e);
    });
  </script>

  <style type="text/css">
    .pep-dpa {
      border-color: blue;
      background: yellow
    }

    .mappedProduct {
      background-color: #feda5d;
      opacity: .5;
    }
  </style>

</head>

<body>

<h1><?php print_r($Bundle['title']); ?></h1>
<div id="Displaybox" >  <?php print_r($Bundle['bundle_product']); ?></div>
</body>






<link rel="stylesheet" href="resourses/jquery-nicemodal.css">
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">


<button data-url="filters.php" id="demo"></button>
<script src="resourses/jquery-nicemodal.js"></script>
<script>
  $(function() {

    $('button#demo').nicemodal({
      width: '500px',
      keyCodeToClose: 27,
      defaultCloseButton: true,
      closeOnClickOverlay: true,
      closeOnDblClickOverlay: false,
      onOpenModal: function() {

      },
      onCloseModal: function() {

      }
    });
  });
</script>


</html>

<link href="resourses/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<script src="resourses/jquery.contextMenu.js" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
    $.contextMenu({
      selector: '.context-menu-one',
      callback: function(key, options) {

        var $this = $(this);
        var contextId = $this.context.id;
        var m = "clicked: " + key;
        if (key == 'add') {
          addProduct();
        }
        if (key == 'change') {
          changeProduct(contextId);
        }
        if (key == 'delete') {
          deleteProduct(contextId);
        }
        if (key == 'reset') {
          resetProduct(contextId);
        }

        function mapobject() {
          $("#mapobject").val(contextId);
        }
        // use setTimeout() to execute
        setTimeout(mapobject, 3000);
      },
      items: {
        "add": {
          name: "Add Product",
          icon: "add",
          accesskey: "e"
        },
        "change": {
          name: "Change Product",
          icon: "edit",
          accesskey: "c"
        },
        "reset": {
          name: "Reset",
          icon: "delete"
        },  "delete": {
            name: "Delete",
            icon: "delete"
          },
        "sep1": "---------",
        "quit": {
          name: "Quit",
          icon: function($element, key, item) {
            return 'context-menu-icon context-menu-icon-quit';
          }
        }
      }
    });
  });



 function addProduct() { $("#demo").trigger("click"); }
 function deleteProduct(id) { $( "#"+id ).remove(); }
 function resetProduct(id) {
   $("#"+id).attr("model", "");
   $("#"+id).attr("productId", "");
   $("#"+id).attr("year", "");
   $("#"+id).removeClass("mappedProduct");
  }

 function changeProduct(id) {
   $("#demo").trigger("click");
 }

  function mapProduct() {

    var mapobject = $("#mapobject").val();
    var model = $("#modeldropdown").val();
    var year = $("#yeardropdown").val();
    var productId = $("#productdropdown").val();
    $("#" + mapobject).attr("model", model);
    $("#" + mapobject).addClass("mappedProduct");
    $("#" + mapobject).attr("year", year);
    $("#" + mapobject).attr("productId", productId);
    $(".nicemodal-close-button").trigger("click");
  }



  function SaveBundle() {
    var bundleData = $("#Displaybox").html();
    var type = 'BundleData';

    $.ajax({
  		url: 'request.php',
  		type: 'POST',
  		data: 'type='+type+'&bundleData='+bundleData+'&bundleId=1',
  		success: function(data) {
        alert(data);
  		},
  		error: function(e) {
  				alert(e.message);
  		}
  	});
  }

</script>





</body>

</html>
