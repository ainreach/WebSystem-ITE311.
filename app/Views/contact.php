<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - ITE311</title>
    <style>
        nav a { margin-right: 12px; }
        body { font-family: Arial, Helvetica, sans-serif; padding: 24px; }
        form { margin-top: 16px; }
        label { display:block; margin: 8px 0 4px; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('/') ?>">Home</a>
        <a href="<?= site_url('about') ?>">About</a>
        <a href="<?= site_url('contact') ?>">Contact</a>
    </nav>
    <h1>Contact</h1>
    <p>This is the contact page.</p>

    <form>
        <label for="name">Name</label>
        <input id="name" name="name" type="text" />
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="4"></textarea>
        <div style="margin-top:10px;"><button type="submit">Send</button></div>
    </form>
</body>
</html>
