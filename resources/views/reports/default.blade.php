<!-- Stored in resources/views/reports/default.blade.php -->

<html>
    <head>
        <title>{{ $name }} 委員 - 行程總表</title>
        <style>
            .container {
                display: flex;
                flex-flow: column;
                align-items: center;
            }
            .title,
            .events {
                display: flex;
                flex-flow: column;
                width: 500px;
            }
            .title {
                align-items: center;
            }
            .title-text {
                width: 100%;
                text-align: center;
            }
            .event {
                margin: 0.8em 0;
                display: flex;
            }
            .event-date {
                min-width: 88px;
            }
        </style>
    </head>
    <body>
        <div class="header container">
            <div class="title">
                <img src="https://vectr.com/pm5/b5l3oqttm.png?width=93&height=58.52&select=b5l3oqttmpage0"/>
                <h1 class="title-text">{{ $name }} 委員 - 行程總表</h1>
            </div>
        </div>
        <div class="container">
            <div class="events">
            @foreach ($events as $event)
                <section class="event">
                    <div class="event-date">
                        {{$event->date}}
                    </div>
                    <div class="event-details">
                        @foreach ($event->categories as $category)
                            【{{$category->name}}】
                        @endforeach
                        {{$event->name}}
                        {{$event->description}}
                    </div>
                </section>
            @endforeach
            </div>
        </div>
        <div class="footer container">
        </div>
    </body>
</html>
