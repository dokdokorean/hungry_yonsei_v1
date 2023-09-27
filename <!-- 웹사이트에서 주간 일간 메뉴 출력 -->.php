<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Weekly Menu</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php
    // 데이터베이스 연결 설정
    $host = 'localhost';
    $db = 'MENU_SMS';
    $user = 'root';
    $password = '41503856';

    try {
        // 데이터베이스 연결
        $connection = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 월요일부터 일주일 간의 일간 메뉴 조회
        $query = "SELECT d.date, m.menu, m.price
                  FROM DAILY_SMS_NM d
                  JOIN MENU_SMS_NM m ON d.MENU_SMS_NM_id = m.id
                  WHERE DAYOFWEEK(d.date) = 2
                        AND d.date >= DATE_ADD(CURRENT_DATE(), INTERVAL -7 DAY)
                        AND d.date <= CURRENT_DATE()
                  ORDER BY d.date";

        // 쿼리 실행
        $stmt = $connection->query($query);
        $weeklyDailyMenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
    
    <h1>주간 메뉴</h1>
    <table>
        <tr>
            <th>날짜</th>
            <th>메뉴</th>
            <th>가격</th>
        </tr>
        <?php foreach ($weeklyDailyMenus as $dailyMenu) { ?>
        <tr>
            <td><?php echo $dailyMenu['date']; ?></td>
            <td><?php echo $dailyMenu['menu']; ?></td>
            <td><?php echo $dailyMenu['price']; ?>원</td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>