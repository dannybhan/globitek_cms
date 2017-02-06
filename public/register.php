<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
$first_name = "";
$last_name = "";
$email = "";
$username = "";
$today = date("Y-m-d H:i:s");
$errors = array();

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
if(is_post_request()) {
    // Confirm that POST values are present before accessing them.
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    // Check first name
    if (is_blank($_POST['first_name'])) {
        $errors[] = "First name cannot be blank.";
    } elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "First name must be between 2 and 255 characters.";
    }
    
    // Check last name
    if (is_blank($_POST['last_name'])) {
        $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Last name must be between 2 and 255 characters.";
    }
    
    // Check email
    if (is_blank($_POST['email'])) {
        $errors[] = "Email cannot be blank.";
    } elseif (!has_length($_POST['email'], ['min' => 1, 'max' => 255])) {
        $errors[] = "Email must be less than 255 characters.";
    } elseif (!has_valid_email_format($_POST['email'])) {
        $errors[] = "Email must be a valid format.";
    }
    
    // Check username
    if (is_blank($_POST['username'])) {
        $errors[] = "Username cannot be blank.";
    } elseif (!has_length($_POST['email'], ['min' => 8, 'max' => 255])) {
        $errors[] = "Email must be between 8 and 255 characters.";
    }

    // if there were no errors, submit data to database
    if (empty($errors)) {
      // Write SQL INSERT statement
      // $sql = "";
        $sql = "INSERT INTO globitek.users (first_name, last_name, email, username, created_at) 
        VALUES ('$first_name', '$last_name', '$email', '$username', '$today')";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);
        $result = db_query($db, $sql);
        if ($result) {
            db_close($db);

      //   TODO redirect user to success page
            header("Location: registration_success.php");
            exit;

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }
        } else {
            echo db_error($db);
            db_close($db);
            exit;
        }
    }
}
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    if (isset($_POST['$errors'])) {
        display_errors($errors);
    }

  ?>

  <!-- TODO: HTML form goes here -->
    <form action="" method="post">
        First Name:<br>
        <input type="text" name="first_name" value="<?php echo $first_name; ?>"><br>
        Last Name:<br>
        <input type="text" name="last_name" value="<?php echo $last_name; ?>"><br>
        Email:<br>
        <input type="text" name="email" value="<?php echo $email; ?>"><br>
        Username:<br>
        <input type="text" name="username" value="<?php echo $username; ?>"><br>
        <br>
        <input type="submit" value="Submit">
    </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
