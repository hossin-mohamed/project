<?php 
include './parts/header.php'; 
include './inc/db.php'; 
include './inc/form.php'; 
include './inc/select.php'; 

// Initialize error array
$error = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and assign form data to variables
    $FirstName = htmlspecialchars(trim($_POST["firstName"]));
    $LastName = htmlspecialchars(trim($_POST["lastName"]));
    $Email = htmlspecialchars(trim($_POST["email"]));

    // Validate inputs
    if (empty($FirstName)) {
        $error['firstName'] = "الرجاء ادخال الاسم الاول.";
    }
    if (empty($LastName)) {
        $error['lastName'] = "الرجاء ادخال الاسم الاخير.";
    }
    if (empty($Email)) {
        $error['email'] = "الرجاء ادخال البريد الالكتروني.";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "البريد الالكتروني غير صحيح.";
    }

    // If there are no errors, proceed with database insertion
    if (empty($error)) {
        $sql = "INSERT INTO users(firstName, lastName, email) VALUES ('$FirstName', '$LastName', '$Email')";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
            exit; // Ensure no further code is executed
        } else {
            $error['db'] = 'Error: ' . mysqli_error($conn);
        }
    }
}

include './inc/db_close.php'; 
?>






<!-- HTML Section -->
<div class="catch m-2 p-2"  >

    <label class="switch">
        <input type="checkbox" id="modeToggle">
        <span class="slider"></span>
    </label>
    <span id="modeLabel" >Light Mode</span>
</div>

<a href=""  id="scrollToTopBtn" class="scrollToTopBtn">
<span>&#8593;</span>
</a>


<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center ">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <img src="./images/Untitled-1.jpg" alt="" style="width: 200px; height: 200px; border-radius:50%;">
        <br>
        <br>
        <center>

            <h1 class="display-4 fw-normal"><h1 class="move">جد عملك و تعلم واربح مع  </h1></h1>
            <h1 class="display-4 fw-normal"><h1 class="move">حسين/Hussein </h1></h1>
        </center>
        <br>
        <h3 id="demo" class="progress-text">0%</h3>
        <p class="lead fw-normal">باقي علي التسجيل للسحب من نسخه مجانيه للفوتوشوب</p>
    </div>
    <div class="container">
        <h3>للدخول في السحب اتبع مايلي</h3>
        <br>
        <ul class="list-group-flush" style="font-size:25px">
            <li class="list-group-item">تابع البث المباشر علي الفيسبوك</li>
            <br>
            <li class="list-group-item">خلال فترة الساعه سيتم تسجيل اسمك وايميلك</li>
            <br>
            <li class="list-group-item">سأقوم ببث مباشر لمده ساعه عن اسئله واجوبه حرة </li>
            <br>
            <li class="list-group-item">في نهايه البث سيتم اختيار اسم واحد من قاعده البينات عشاوئي</li>
            <br>
            <li class="list-group-item">الرابح سيحيصل علي نسخه مجانيه من برنامج فوتوشوب</li>
        </ul>
    </div>
</div>


<div class="container">
    <div class="position-relative text-center">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <h3>الرجاء ادخل معلوماتك</h3>

                <div class="mb-3">
                    <label for="firstName" class="form-label" style="font-size:20px">الاسم الاول</label>
                    <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Enter The First Name" value="<?php echo isset($FirstName) ? $FirstName : ''; ?>">
                    <?php if (!empty($error['firstName'])): ?>
                        <p class="text-danger"><?php echo $error['firstName']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="lastName" class="form-label" style="font-size:20px">الاسم الاخير</label>
                    <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Enter The Last Name" value="<?php echo isset($LastName) ? $LastName : ''; ?>">
                    <?php if (!empty($error['lastName'])): ?>
                        <p class="text-danger"><?php echo $error['lastName']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label" style="font-size:20px">البريد الالكتروني</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Enter The Email" value="<?php echo isset($Email) ? $Email : ''; ?>">
                    <?php if (!empty($error['email'])): ?>
                        <p class="text-danger"><?php echo $error['email']; ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">ارسال المعلومات</button>
            </form>
        </div>
    </div>
</div>

<!-- Progress Bar -->
<div class="cont">
    <div class="progress-bar">
        <div class="progress" id="circularLoader"></div>
    </div>
</div>

<!-- Button trigger modal -->
<div class="d-grid gap-2 col-6 mx-auto my-5">
    <button id="winner" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
        اختيار الرابح 
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #086EFC; width:auto; color:white;">
                <h5 class="modal-title" id="modalLabel">الرابح في المسابقه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: red ;"></button>
            </div>
            <div class="modal-body" >
                <?php foreach ($users as $user) : ?>
                    <center>
                        <h5 class="display-2 text-center modal-title" id="modalLabel" style="font-weight: bold; text-transform:capitalize; color:black;"><?php echo htmlspecialchars($user['firstName']) . ' ' . htmlspecialchars($user['lastName']) ?></h5>
                    </center>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include './parts/footer.php'; ?>