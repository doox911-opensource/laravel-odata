# Laravel OData

# Установка

### Composer

```bash
composer require doox911-opensource/laravel-odata
```

### Конфигурация

```bash
php artisan vendor:publish --tag=doox911-opensource-odata-config
```

## Перед началом работы

В `.env` необходимо указать авторизацию:
- Для **Basic**:
  ```dotenv
  ODATA_AUTH_LOGIN = login
  ODATA_AUTH_PASSWORD = password
  ```
