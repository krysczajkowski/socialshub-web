<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; 

if(!$functions->loggedIn()) {
    header('Location: index.php');
}

//Generate a secure token using openssl_random_pseudo_bytes.
$myToken = bin2hex(openssl_random_pseudo_bytes(24));
//Store the token as a session variable.
$_SESSION['token_special'] = $myToken;
?>

<style>
h1 {
	text-align: center;
}
#sortable {
	list-style-type: none;
}

</style>
 
<body>
   
    <?php include 'includes/nav.php';
        //We check is user active and if he is not we change his location to welcome.php
        $functions->isUserActive($user->active);
                
    ?>
    
    
    <div class="bg-white my-5 border rounded container">
        <div class="row settings-card">
           
            <!-- LEFT SETTINGS PANEL -->
            <div class="d-none d-md-block col-md-4 col-lg-3">
                <div class="row">
                    <div class="col-12 my-3 pl-4">
                        <a href="settings.php" class='text-dark h5 none-decoration'>Edit Profile</a>
                    </div>
                    <div class="col-12 my-3 pl-4 border-left border-dark">
                        <a href="settings-links.php" class='text-dark h5 none-decoration'>My Links</a>
                    </div>
                    <div class="col-12 my-3 pl-4">
                        <a href="settings-theme.php" class='text-dark h5 none-decoration'>Links Theme</a>
                    </div>
                    <?php if(!$functions->isUserFbUser($user->id)) {?>
                    <div class="col-12 my-3 pl-4">
                        <a href="edit-password.php" class='text-dark h5 none-decoration'>Change Password</a>
                    </div>
                    <?php } ?>
                    <div class="col-12 my-3 pl-4">
                        <a href="privacy_and_security.php" class='text-dark h5 none-decoration'>Privacy and Security</a>
                    </div>
                    <div class="col-12 my-3 pl-4">
                        <a href="logout.php" class='text-dark h5 none-decoration'>Logout</a>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SETTINGS PANEL -->
            <div class="col-md-8 col-lg-9 border-left">

			    <div class='custom-links-container'>

                   <!-- Go to custom links message for mobile users -->
                    <div class="row d-block d-md-none d-lg-none d-lg-none border-bottom border-secondary text-center pt-1 pb-3 mb-5">
<!--                         <div class="col-12">
                            <a href="settings.php" class="link pb-3"><i class="fas fa-user-edit"></i> Edit Your Profile</a>
                        </div> -->
                        <div class="col-12 font-weight-bold">
                            <a href="settings-theme.php" class="link h5"><i class="fas fa-palette mt-3"></i> Change your links's theme</a>
                        </div>
                    </div>


    				<h1 class='h3 font-weight-bold'>My Links</h1>
    				<div class="row">
    					<div class="col">
    						<div class="form-group">
    							<input type="text" id="title" class="form-control" placeholder="Link title" >							
    							<input type="hidden" id="id_title">
    						</div>
    						<div class="form-group mb-2 pb-0">
    							<input type="text" id="description" class="form-control" placeholder="Link description" id="link">
                                <p class="my-0 py-0  super-small-font font-weight-bold text-muted">Description is optional</p>
                                <input type="hidden" id="id_description">
    						</div>
    						<div class="form-group">
    							<input type="text" id="link" class="form-control" placeholder="https://url" id="link">
    							<div class="error d-none error-message alert alert-danger alert-dismissible mt-2">
    							</div>
    							<input type="hidden" id="id_link">
                                <!--Hidden field containing our session token-->
                                <input type="hidden" id="token_special" name="token_special" value="<?= $_SESSION['token_special']; ?>">
    						</div>
                            <div class="text-center mt-4 mb-3">
                                <h5 class="font-weight-bold text-muted pb-0 mb-1">Add an image <i class="far fa-file-image"></i></h5>
                                <p class="text-muted font-weight-bold super-small-font">It's not required</p>
                            </div>		
                            <div class='bg-light'>
                                <input type="file" name="linkImg" id="linkImg" class='py-2 px-auto'>				
                            </div>
                            <div class="text-muted font-weight-bold super-small-font mb-3 ">Only .jpg, .jpeg or .png allowed</div>
                            
    						<a href="#" id="save_button" class="btn btn-primary btn-lg btn-block normal-font font-weight-bold">ADD NEW LINK</a>
    					</div>
    				</div>

    				<div class="row mt-4">
    					<div class="col">
    						<div class="form-group">
    							<form id="sortable_form">
    								<ul id="sortable" class="list-group">
    								</ul>
    							</form>
    							<a href="#" id="delete_button" class="mt-2 btn btn-danger btn-lg btn-block d-none">Delete selected</a>
    						</div>
    					</div>
    				</div>


                </div>
                
            </div>

        </div>
    </div>
   
    <!-- Including footer -->
    <?php include 'includes/footer.php'; ?>
   
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include 'js/script.php' ?>
    <script src='js/search.js'></script>
    <script>
        //Funkcja collapse('hide') chowa wszystkie elementy, a po tym pojawia się ten który klikneliśmy
        $('.port-item').click(function(){
            $('.collapse').collapse('hide')
        })

    </script>
<script>
    $(function() {

        $.fn.sortableli = function() {
            $("#sortable li").each(function(index){
                var parent = $(this);
               /* $( this ).hover(function(){
                    var cb = $(this).find(":checkbox");
                    $(this).find("img").toggleClass('display-show');
                    if(!cb.is(':checked')){
                        cb.toggleClass('display-show');
                    }
                });*/
                $(this).find(".fa-edit").click(function(){					
                    $("#title").val($(this).attr('data'));
                    $("#description").val($(this).attr('data-description'));
					$("#link").val( parent.find("a").attr('href') );
                    $("#id_link").val($(this).attr('id'));
                    $("#link").focus();
                    return false;
                });
            });

            $(this).find(":checkbox").click(function(){
                $('#delete_button').addClass('d-none');
                $(".checkbox").each(function(index){
                    if($(this).is(':checked')){
                        $('#delete_button').removeClass('d-none');
                    }
                });
            });
            return this;
        };

        // Get all active bookmark
        $.fn.selectable = function() {
            $.post( "ajax/select.php", function(data){
                $("#sortable").html('');
                $("#sortable").prepend(data);
                $("#sortable").sortableli();
            } );
            return this;
        };

        // Create sortable
        $( "#sortable" ).selectable();
        $( "#sortable" ).sortable({
            placeholder: "ui-state-highlight",
            update: function( event, ui ) {
                var sorted = $( "#sortable" ).sortable( "serialize", { key: "sort" } );
                $.post( "ajax/order.php",{ 'choices[]': sorted});
            }
        });
        $( "#sortable" ).disableSelection();

        // Insert new link
        $("#save_button").click(function(){
            $(".error-message").addClass("d-none");

            if($("#link").val().length > 0){
                if(Validalink($("#link").val())){
                    // $.post( "ajax/insert.php", { title: $("#title").val(),link: $("#link").val(),id: $("#id_link").val(),token_special: $("#token_special").val() }, function(data){
                    //     $( "#sortable" ).selectable();
                    //     $('#link').val('');
                    // } );

                    var formData = new FormData();
                    formData.append('title', $("#title").val());
                    formData.append('description', $("#description").val());
                    formData.append('link', $("#link").val());
                    formData.append('id', $("#id_link").val());
                    formData.append('token_special', $("#token_special").val() );

                    if ($('#linkImg').get(0).files.length > 0) {
                        formData.append('file', $('#linkImg').prop('files')[0]);
                    }

                    $.ajax({
                        url: 'ajax/insert.php',
                        type: 'POST',
                        data: formData,
                        contentType: false, // musi byc, bo inaczej wysyla wyswietla linki
                        processData:false, // musi byc, bo inaczej wysyla blad
                        success: function(response){
                            $( "#sortable" ).selectable();
                            $('#link').val('');
                        },
                    });

                    $("#id_link").val('');
					$("#title").val('');
                    $("#description").val('');
                }else{
                    $(".error-message").html("Please provide a valid link.");
                    $(".error-message").removeClass("d-none");
                }
            }else{
                $(".error-message").html("Please enter your link.");
                $(".error-message").removeClass("d-none");
            }
            return false;
        });

        // Delete link
        $(document).on('click','.fa-trash',function(){
			
            // array_val =  [];

            // $(".checkbox").each(function(index){
                // if($(this).is(':checked')){
                    // array_val.push($(this).attr('id'));
                // }
            // });
			
			
            $.post( "ajax/delete.php",{'choice':$(this).attr('id')}, function(data){
                $( "#sortable" ).selectable();
                //$('#delete_button').addClass('display-none');
            } );
            return false;
        });

    });

    function Validalink(link) {
        var regex=/^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i;
        return regex.test(link);
    }
</script>	
</body>
</html>
