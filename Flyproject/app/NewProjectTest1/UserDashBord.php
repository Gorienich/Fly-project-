<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="airdatepicker/air-datepicker.css">
</head>

<body>
 <!-- Create form to rent date plane -->

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <input type="text" id="airdatepicker" class="form-control" name="dateForPlane">
            </div>
        </div>
        
    </div>


    <script src="airdatepicker/air-datepicker.js"></script>
    <script>
        new AirDatepicker('#airdatepicker', {
            // isMobile: true,
            // autoClose: false,
            // position: 'right top',
            // range: true,
            // multipleDatesSeparator: ' - '
            // timepicker: true,
            // Handle render process
            /*onRenderCell({date, cellType}) {
                let dates = [1, 5, 7, 10, 15, 20, 25],
                emoji = ['💕', '😃', '🍙', '🍣', '🍻', '🎉', '🥁'],
                isDay = cellType === 'day',
                _date = date.getDate(),
                shouldChangeContent = isDay && dates.includes(_date),
                randomEmoji = emoji[Math.floor(Math.random() * emoji.length)];

                return {
                    html: shouldChangeContent ? randomEmoji : false,
                    classes: shouldChangeContent ? '-emoji-cell-' : false
                }
            }*/
            buttons: ['today', 'clear'],
            locale: {
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                today: 'Today',
                clear: 'Clear',
                dateFormat: 'dd.MM.yyyy',
                timeFormat: 'hh:mm aa',
                firstDay: 0
            }
        });
    </script>

</body>
</html>