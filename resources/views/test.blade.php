@component('message')
    # Здравствуйте!

    Информируем Вас о том, что по запросу №1 было сделано ценовое предложение. Срок подачи ценовых предложений продлен на 30 минут.
    Перейти в раздел запроса можно по ссылке

    @component('mail::button', ['url' => 1])
        Перейти
    @endcomponent

    С наилучшими пожеланиями, команда {{ config('app.name') }}<br>
    Тел.: 8800 222 4007
@endcomponent