## Dokumentacja API dla systemu zapisywania kursów walut

**Instalacja**

```sh
git clone https://github.com/bpastuchewicz/krg.git
cd krg
mv .env.example .env 
#Konfiguracja bazy danych w pliku .env
composer install
php artisan migrate
php artisan serve
```

Teraz można korzystać z metod udostępnionych w API

**API**

Można zaimportować do Postmana kolekcję znajdującą się w pliku [Laravel.postman_collection.json](https://github.com/bpastuchewicz/krg/blob/main/Laravel.postman_collection.json)

1.POST */api/auth/register* - rejestracja użytkownika

Rejestrujemy użytkownika i przypisujemy go do określonej roli : admin lub user

parametry json
```json
{
	"name" : "User Name",
	"email": "user@email.com",
	"password":"****",
	"role":"admin"
}

```
2.POST */api/auth/login* - logujemy użytkownika i uzyskujemy token autoryzacyjny

parametry json
```json
{
	"email": "user@email.com",
	"password":"****"
}
```
3.GET */api/exchange_rates* - pobieramy listę kursów z bieżącego dnia

Autoryzacja bearer token z użyciem tokena uzyskanego z logowania, wymagana rola user

4.GET */api/exchange_rates/{date}* - pobieramy listę kursów z wybranego dnia

Autoryzacja bearer token z użyciem tokena uzyskanego z logowania, wymagana rola user

Data w formacie Y-m-d

5.GET */api/exchange_rate/{currency}* - pobieramy kurs waluty dla bieżącego dnia

Dostępne waluty to EUR, USD, GBP

Autoryzacja bearer token z użyciem tokena uzyskanego z logowania, wymagana rola user

6.GET */api/exchange_rate/{currency}/{date}* - pobieramy kurs waluty z podanego dnia

Dostępne waluty to EUR, USD, GBP

Autoryzacja bearer token z użyciem tokena uzyskanego z logowania, wymagana rola user

7.POST */exchange_rate* - zapisujemy kurs waluty z danego dnia

parametry json
```json
{
	"currency" : "EUR",
	"amount": 4.6656,
	"date":"2023-04-23"
}
```
Parametr date jest opcjonalny, domyślnie dodawany jest kurs z bieżącą datą

Autoryzacja bearer token z użyciem tokena uzyskanego z logowania, wymagana rola admin

