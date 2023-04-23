## Dokumentacja API dla systemu zapisywania kursów walut

1. Instalacja
2. API

2.1./api/auth/register - rejestracja użytkownika

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
2.2./api/auth/login - logujemy użytkownika i uzyskujemy token autoryzacyjny

parametry json
```json
{
	"email": "user@email.com",
	"password":"****"
}
```
2.3. /api/exchange_rates/ - pobieramy listę kursów z bieżącego dnia

Autoryzacja bearer token z użyciem tokena uzyskanego z logowania, wymagana rola user

2.4. /api/exchange_rates/{date} - pobieramy listę kursów z wybranego dnia

Autoryzacja bearer token z użyciem tokena uzyskanego z logowania, wymagana rola user

Data w formacie Y-m-d
