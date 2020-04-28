# Тестовое задание для backend-стажёра в юнит Billing
Простая платежная система c JSON API, которая умеет отображать форму оплаты банковской картой и сохраняет 
информацию о платежах.

[![Build Status](https://travis-ci.org/MrSmile2114/avito-billing.svg?branch=master)](https://travis-ci.org/MrSmile2114/avito-billing)
[![codecov](https://codecov.io/gh/MrSmile2114/avito-billing/branch/master/graph/badge.svg)](https://codecov.io/gh/MrSmile2114/avito-billing)

#### Основной функционал
Продавец, с помощью POST метода `/api/payment/register`, получает URL страницы для оплаты с 
идентификатором платёжной сессии.
Переходя по URL, покупатель видет форму оплаты банковской картой. Валидный номер банковской карты имитирует успешную 
оплату.

Время существования сессии ограничено 30 минутами. Для получения новой сессии уже существующего платежа реализован метод
`/api/session/create/`

### API specification
[Спецификация со всеми методами.][2]



### Additional
- [x] Подготовить OpenAPI-спецификацию.
- [x] Покрыть реализацию тестами.
- [x] Ограничить время жизни платёжной сессии 30 минутами.
- [x] Контейнеризация.
- [x] Добавить API-метод, который возвращает список всех платежей за переданный период.
- [x] После успешной оплаты асинхронно отправлять HTTP-уведомление на URL магазина. URL для таких уведомений передаваётся магазином в запросе `/register`.
- [ ] Опубликовать решение как Docker-образ.
- [ ] Пагинация.

## Credits
* [Payment card checkout form][1]

[1]:https://codepen.io/simoberny/pen/XgEgGg
[2]:https://app.swaggerhub.com/apis-docs/MrSmile2114/avito-billing/