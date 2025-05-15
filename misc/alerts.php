<?php

enum AlertType: string
{
    case Message = 'message';
    case Success = 'success';
    case Warning = 'warning';
    case Error = 'error';
}

enum Alert: string
{
    case RegistrationSuccess = 'Успешна регистрация!';
    case UsernameTaken = 'Потребителското име вече съществува!';
    case LoginSuccess = 'Успешно вписване!';
    case LoginCredFailed = 'Грешно потребителско име или парола!';
    case LogoutSuccess = 'Успешно отписване!';
    case MovieAddedSuccessfull = 'Филмът е добавен успешно!';
    case SeriesAddedSuccessfull = 'Сериалът е добавен успешно!';
    case EmptyRequiredFields = 'Има празни задължителни полета!';
    case InvalidGenre = 'Невалиден жанр!';
}

?>