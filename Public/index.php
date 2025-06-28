<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>منصة تحفيظ القرآن الكريم</title>
    <style>
        body { font-family: 'Arial'; direction: rtl; margin: 0; padding: 0; background: #f6f8fa; }
        header, footer { background: #1e3c72; color: white; padding: 20px; text-align: center; }
        main { padding: 30px; }
        section { margin-bottom: 40px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        h2 { color: #1e3c72; }
        a.button {
            background: #1e3c72; color: white; padding: 12px 24px;
            border-radius: 8px; text-decoration: none; font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <h1>📖 منصة تحفيظ القرآن الكريم</h1>
    <p>بيئة تعليمية ملهمة لحفظ كتاب الله وتطوير المهارات الإيمانية</p>
</header>

<main>

    <section>
        <h2>✨ ما هي المنصة؟</h2>
        <p>
            هذه المنصة تربط بين المحفظين، الطلاب، وأولياء الأمور بطريقة تفاعلية، لتنظيم الحفظ، المراجعة، والمتابعة بكل سهولة ودقة.
        </p>
    </section>

    <section>
        <h2>🧑‍🏫 للمحفظين</h2>
        <ul>
            <li>إدارة الطلاب والحلقات بسهولة</li>
            <li>تسجيل الحضور وتتبع التقدم</li>
            <li>مراسلة أولياء الأمور</li>
        </ul>
    </section>

    <section>
        <h2>👨‍🎓 للطلاب</h2>
        <ul>
            <li>استعرض صفحات المصحف وتلاوات صوتية</li>
            <li>نظام تكرار للحفظ</li>
            <li>تحفيز بالإنجازات والمنافسات</li>
        </ul>
    </section>

    <section>
        <h2>📊 أرقام من المنصة</h2>
        <?php
        include '../App/Config/db.php';
        $students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
        $teachers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'")->fetchColumn();
        $recitations = $pdo->query("SELECT COUNT(*) FROM recitations")->fetchColumn();
        ?>
        <p>👨‍🎓 عدد الطلاب: <strong><?= $students ?></strong></p>
        <p>🧑‍🏫 عدد المحفظين: <strong><?= $teachers ?></strong></p>
        <p>🎧 عدد التلاوات المتاحة: <strong><?= $recitations ?></strong></p>
    </section>

    <section style="text-align: center;">
        <h2>🚀 ابدأ الآن</h2>
        <a href="../App/Controller/auth.php" class="button">تسجيل الدخول / البدء</a>
    </section>

</main>

<footer>
    <p>© <?= date('Y') ?> منصة تحفيظ القرآن. جميع الحقوق محفوظة.</p>
</footer>

</body>
</html>
