# Прототип платежной системы
Простая платежная система c JSON API, которая умеет отображать форму оплаты банковской картой и сохраняет 
информацию о платежах.

[![Build Status](https://travis-ci.com/s-shiryaev/avito-billing.svg?branch=master)](https://travis-ci.com/s-shiryaev/avito-billing)
[![codecov](https://codecov.io/gh/s-shiryaev/avito-billing/branch/master/graph/badge.svg)](https://codecov.io/gh/s-shiryaev/avito-billing)

#### Основной функционал
Продавец, с помощью POST метода `/api/payment/register`, получает URL страницы для оплаты с 
идентификатором платёжной сессии.
Переходя по URL, покупатель видит форму оплаты банковской картой. Валидный номер банковской карты имитирует успешную 
оплату.

Время существования сессии ограничено 30 минутами. Для получения новой сессии уже существующего платежа реализован метод
`/api/session/create/`


#### Отправка уведомлений
Запуск Worker для отправки HTTP-уведомлений осуществляется командой `php bin/console messenger:consume async -vv`.


### API specification
[Спецификация со всеми методами.][2]



### Additional
- [x] Подготовить OpenAPI-спецификацию.
- [x] Покрыть реализацию тестами.
- [x] Ограничить время жизни платёжной сессии 30 минутами.
- [x] Контейнеризация.
- [x] Добавить API-метод, который возвращает список всех платежей за переданный период.
- [x] После успешной оплаты асинхронно отправлять HTTP-уведомление на URL магазина. URL для таких уведомений передаваётся магазином в запросе `/register`.
- [x] При неудачной попытке отправки HTTP-уведомления совершаются 3 повторные попытки через 5/10/20 минут.
- [x] Пагинация.

## Credits
* [Payment card checkout form][1]

[1]:https://codepen.io/simoberny/pen/XgEgGg
[2]:https://app.swaggerhub.com/apis-docs/MrSmile2114/avito-billing/
