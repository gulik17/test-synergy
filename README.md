# Тестовое задание Sinergy

### Требования
- Минимальная версия PHP 7.1

### Какие принципы SOLID нарушены в проектирования сервиса отправки уведомлений

#### Нарушено:
- Принцип единой ответственности. Если изменится принцип отправки уведомлений то придется менять метод notify в классе NotificationService, чтобы отправить только SMS или только E-Mail. На каждую сущность должна быть возложена одна единственная задача.
- Принцип открытости-закрытости. Мы не можем расширить метод notify без его модификации. Даже если мы наследуемся от класса NotificationService то нам придется переписать (переопределить) заново весь метод notify чтобы он отвечал новым потребностям, что не соответствует данному принципу. Открыты для расширения, закрыты для модификации.
- Принцип инверсии зависимостей. Класс NotificationService зависит от классов EmailNotificator и SmsNotificator, а не от абстракции.

#### Не нарушено:
 - Принцип Лисков. Нет наследования
 - Принцип разделения интерфейсов. Не используются интерфейсы

### Какие паттерны проектирования можно использовать, чтобы сделать сервис более гибким и способным к легкому расширению способов рассылки

- Паттерн строитель 

### Какие еще проблемы есть в этом коде

Помимо того, что данное решение является не гибким к изменениям в нем используется создание классов в цикле. Если база будет состоять из 1000 юзеров, то чтобы отправить всем уведомления будет создаваться 1000 экземпляров класса EmailNotificator и 1000 SmsNotificator, а после добавления еще одного метода WebPushNotificator будет создаваться еще 1000 экземпляров. Таким образом такой подход будет потреблять слишком много памяти.
