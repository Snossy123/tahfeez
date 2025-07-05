<!-- HTML Form -->
<form method="post">
    <input name="username" placeholder="اسم المستخدم">
    <input type="password" name="password" placeholder="كلمة المرور">
    <select name="role">
        <option value="admin">الإدارة</option>
        <option value="teacher">محفظ</option>
        <option value="student">طالب</option>
        <option value="parent">ولي أمر</option>
    </select>
    <button type="submit">تسجيل الدخول</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form>