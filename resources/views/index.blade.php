<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запрос доступных автомобилей</title>
    <!-- Подключение Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Запрос доступных автомобилей</h2>
    <form id="carForm">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="employee_id">ID Сотрудника:</label>
            <input type="number" class="form-control" id="employee_id" name="employee_id" required>
        </div>

        <div class="form-group">
            <label for="start_time">Время начала:</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>

        <div class="form-group">
            <label for="end_time">Время окончания:</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>

        <button type="button" id="submitForm" class="btn btn-primary">Отправить</button>
    </form>
</div>

<!-- Модальное окно -->
<div class="modal fade" id="carsModal" tabindex="-1" aria-labelledby="carsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carsModalLabel">Доступные автомобили</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select id="carsDropdown" class="form-control">
                    <!-- Опции будут добавлены динамически -->
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" id="zakaz" class="btn btn-success" data-dismiss="modal">Заказать</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<!-- Подключение jQuery и Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#zakaz').on('click', () => {
            // Закрыть предыдущее модальное окно
            $('#carsModal').modal('hide');

            // Убедиться, что новое модальное окно откроется только после закрытия предыдущего
            $('#carsModal').on('hidden.bs.modal', function () {
                // Открыть новое модальное окно с сообщением "машина заказана"
                alert('Машина заказана');
            });
        });

        // Обработка формы при нажатии на кнопку
        $('#submitForm').on('click', function() {
            // Получаем данные формы
            let formData = {
                employee_id: $('#employee_id').val(),
                start_time: $('#start_time').val(),
                end_time: $('#end_time').val(),
                _token: $('input[name="_token"]').val()
            };

            // Выполняем AJAX-запрос к контроллеру
            $.ajax({
                url: 'http://127.0.0.1:8000/get-available-cars',
                method: 'POST',
                data: formData,

                success: function(response) {
                    // Очищаем существующие опции в выпадающем списке

                    // Заполняем выпадающий список полученными данными
                    response.forEach(car => {
                        let driverName = car.driver.name;
                        let optionText = `${car.model} (${driverName}) - Комфорт: ${car.comfort_category}`;
                        $('<option>').val(car.id).text(optionText).appendTo('#carsDropdown');
                    });

                    // Открываем модальное окно
                    $('#carsModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert(`Ошибка: ${error}`);
                }

            });

        });
    });
</script>
</body>
</html>
