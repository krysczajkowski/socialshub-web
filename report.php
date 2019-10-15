<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>
 
<body>
   <?php include 'includes/index-nav.php'; ?>
    <div class="bg-white my-5 border rounded container">
        <div class="row">
            <!-- LEFT SETTINGS PANEL -->
            <div class="d-none d-md-block col-md-4 col-lg-3">
                <div class="row">
                    <div class="col-12 my-3 pl-4">
                        <a href="terms.php" class='text-dark h5 none-decoration'>Terms of Use</a>
                    </div>
                    <div class="col-12 my-3 pl-4">
                        <a href="privacy-policy.php" class='text-dark h5 none-decoration'>Privacy Policy</a>
                    </div>
                    <div class="col-12 my-3 pl-4 border-left border-dark">
                        <a href="report.php" class='text-dark h5 none-decoration'>Report Something</a>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SETTINGS PANEL -->
            <div class="col-md-8 col-lg-9 border-left">
                <div class="m-4">
                   
                   dupa 

                </div>
            </div>
        </div>
    </div>
   
    <!-- Including footer -->
    <?php include 'includes/footer.php'; ?>   

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include 'js/script.php' ?>
    <script src='js/search.js'></script>
</body>
</html>
