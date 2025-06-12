# To-Do List Application

## Uruchomienie projektu z Dockerem

### 1. Budowa i uruchomienie kontenerów

W katalogu głównym projektu uruchom następujące komendy:

```bash
# Buduje i uruchamia kontenery w tle
docker-compose up -d --build

# Sprawdź logi kontenera aplikacji, jeśli chcesz monitorować
docker-compose logs -f app
```
1. Plik .env

Skonfiguruj połączenie z bazą danych MySQL:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

2. Konfiguracja SMTP (Mailtrap)

Przykładowa konfiguracja SMTP do wysyłania e-maili (Mailtrap):

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

3. Konfiguracja integracji Google Calendar

Pobierz i wygeneruj plik z danymi uwierzytelniającymi do Google API zgodnie z instrukcją z repozytorium:
https://github.com/spatie/laravel-google-calendar

Umieść plik credentials.json (lub inny plik konfiguracyjny Google API) w katalogu storage/app/google-calendar/ (lub innym, który skonfigurujesz).

W pliku .env ustaw zmienną środowiskową z ID kalendarza Google:

GOOGLE_CALENDAR_ID=twoj_kalendarz_google_id

Dodatkowo skonfiguruj usługę Google Calendar w Laravel według dokumentacji Spatie.

docker exec -it to_do_list_app bash
php artisan migrate:fresh --seed