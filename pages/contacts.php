<?php
// страница контакти

if (isset($_POST['submit'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty(trim($name)) || empty(trim($email)) || empty(trim($message))) {
        echo '<div class="alert alert-danger" role="alert">Моля попълнете всички полета</div>';
    } else {
        echo '
            <div class="alert alert-success" role="alert">
                <div>Благодарим за вашето съобщение, ' . $name . '!</div>
                <div>На имейл ' . $email . ' ще получите отговор на съобщението.</div>
            </div>
        ';

        $name = '';
        $email = '';
        $message = '';
    }
}

?>
<h1>Свържете се с нас</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Имена</label>
        <input type="text" class="form-control" id="name" placeholder="Your Name" name="name" value="<?php echo $name ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Имейл</label>
        <input type="email" class="form-control" id="email" placeholder="Your Email" name="email" value="<?php echo $email ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Съобщение</label>
        <textarea class="form-control" id="message" rows="4" name="message"><?php echo $message ?? '' ?></textarea>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Изпрати</button>
</form>