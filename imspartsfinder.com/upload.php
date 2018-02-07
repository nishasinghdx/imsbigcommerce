
<script type="text/javascript" src="resourses/jquery.js" ></script>
<script type="text/javascript" src="resourses/ajaxupload.3.5.js" ></script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'request.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){

				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response==="success"){
					$('<li></li>').appendTo('#files').html('<img src="./assets/uploads/'+file+'" alt="" /><br />'+file).addClass('success');
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});

	});
</script>
<div id="mainbody" >

		<!-- Upload Button, use any id you wish-->
		<div id="upload" ><img src="resourses/Images/uapload.png"/></div><span id="status" ></span>

		<ul id="files" ></ul>
</div>
