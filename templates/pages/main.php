<?php

use App\Repository\CurrenciesRepository;

$title = 'Главная';
require_once APP_DIR . PAGE_DIR . 'layout' . DIRECTORY_SEPARATOR . 'header.php';
//Подключаем флеш сообщения
require_once APP_DIR . PAGE_DIR . 'layout' . DIRECTORY_SEPARATOR . 'flash_messages.php';
$currenciesRepository = new CurrenciesRepository();
$currencies = $currenciesRepository->getCurrencies();
$calculateType = $_SESSION['calculate_type'] ?? '';
$currencyName = $_SESSION['currency_name'] ?? '';
?>
<div>
    <a class="logout" href="/logout">Выйти</a>
    <?php
    if (!empty($currencies)) { ?>
        <table class="currencies_table">
            <thead>
            <tr>
                <th>USD, 1$</th>
                <th>EUR, 1€</th>
                <th>CNY, 1¥</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                foreach ($currencies as $currency) { ?>
                    <td><?= ceil($currency['exchange_rate'] * 100) / 100 ?> ₽</td>
                <?php }
                ?>
            </tr>
            </tbody>
        </table>
    <?php } else { ?>
        <h1 class="currencies_table">Сервис недоступен</h1>
    <?php }
    ?>
</div>

<form action="/main" method="post">
    <table class="currencies_table">
        <thead>
        <tr>
            <th style="height: 30px">
                <label for="type">Конвертировать </label>
                <select name="type" id="type">
                    <option <?=$calculateType == 'to_rub' ? 'selected' : ''?>
                            value="to_rub">в рубли
                    </option>
                    <option <?=$calculateType == 'from_rub' ? 'selected' : ''?>
                            value="from_rub">из рублей в валюту
                    </option>
                </select><br>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <label>Введите сумму:
                    <input value="<?=$_SESSION['number'] ?? null ?>" type="number" name="number" style="width: 100px" required/>
                </label>

                <label for="currency">Выберите валюту:</label>
                <select name="currency" id="currency">
                    <?php
                    foreach ($currencies as $currency) { ?>
                        <option
                                <?=$currencyName == $currency['currency_name'] ? 'selected' : null ?>
                                value="<?= $currency['exchange_rate'] . '*' . $currency['currency_name'] ?>">
                            <?= $currency['currency_name'] ?>
                        </option>
                    <?php
                    }
                    ?>
                </select><br>
                <br>
                <button type="submit" name="to_rub">Рассчитать</button>

            </td>
        </tr>
        <tr>
            <td>Итого: <?= $total ?? '' ?></td>
        </tr>
        </tbody>
    </table>
</form>
</body>
</html>