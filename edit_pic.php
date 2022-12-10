<form enctype = "multipart/form-data" id="form">



    <div class= "button-block">

        <div class="image"></div>

        <div class= "file-btn">
            <input type = "file" name="file" id="file"> 
        </div>

        <div class="sumbit-btn">
            <input type="submit" name= "file" class= "EditPicBtn" value="Change">
        </div>

    </div>


</form>

<script type="text/javascript">

    $(document).ready(function(){

            $("#form").on('submit',function(e){
                e.preventDefault();

                if(!$("#file").val()){
                    alert("Please choose a file");
                }

                var formData = new FormData(this);

                $.ajax({
                    url:"edit_pic_in.php",
                    type:"POST",
                    data:formData,
                    cache:false,
                    processData:false,
                    contentType:false,

                    success:function(data){
                        $(".image").html(data);
                    }
                });


            });



            $("#file").change(function(){

                var file = this.files[0];
                var fileType = file.type;
                var file_size = file.size;
                var match = ['image/jpeg','image/jpg','image/png'];

                if(!( (fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) )){
                     alert("select JPEG, JPG or PNG to upload");
                     $("#file").val('');
                     return false;
                }

                if(file_size > 5000000){/*5000 Kb*/
                    
                    alert("Sorry file size too big");
                    $("#file").val('');
                    return false;
                
                }

            });
    });

</script>