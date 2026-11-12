# 💧 Ak Suw Zawody (water_suw) — Laravel web site

Suw we içgi zawodynyň web sahypasy. Taslamany ýerine ýetiren: **Yusup Gajaýew**.

## 🚀 Işletmek (Windows / XAMPP)

```bash
composer install
copy .env.example .env        # (.env eýýäm bar bolsa gerek däl)
php artisan key:generate      # (.env täze bolsa)
# MySQL-de "water_suw" atly database döret (phpMyAdmin → New → water_suw)
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Brauzerde: http://127.0.0.1:8000

| Rol | E-poçta | Parol |
|-----|---------|-------|
| Admin | yusup@water.com | password123 |
| Ulanyjy | mugallym@water.com | password123 |

> Täze agza bolan her kim **ulanyjy** (user) bolýar. CRUD (goşmak / üýtgetmek / pozmak) we soraglara jogap bermek diňe **admin** üçin.

## 📧 Gmail bilen e-poçta (email practice)

`.env` faýlynda:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seniň.gmail@gmail.com
MAIL_PASSWORD=16_belgili_app_password   # Google → Security → 2-Step → App passwords
MAIL_FROM_ADDRESS="seniň.gmail@gmail.com"
```

Soňra: `php artisan config:clear`. "Paroly unutdyňyzmy?" → Gmail-e 6 belgili kod gelýär.
`MAIL_MAILER=log` bolsa kod synag üçin ekranda hem görkezilýär (APP_DEBUG=true wagtynda).

## 🔐 Hasap akymy (Gmail kody bilen)

1. **Agza bol** → Gmail-e 6 belgili kod gelýär → kody `/verify-email` sahypasynda ýazýarsyň → hasap açylýar we awtomatiki girýär (kod girizilmänkä girip bolmaýar).
2. **Login** → parol dogry, ýöne Gmail tassyklanmadyk bolsa täze kod ugradylýar.
3. **Paroly unutdym** → Gmail-e kod → kody ýaz + täze parol → ulgama girýär.
4. **Profil** (`/profile`, ýokardaky ady basyň) → ady/telefony/salgyny üýtgetmek we **häzirki parol bilen täze parol saýlamak**.

## ✅ Mugallymyň talaplary — nirede?

| Talap | Nirede |
|-------|--------|
| 5 model | `User, Category, Water, Order, Question` (`app/Models`) |
| 5 controller | `AuthController, CategoryController, WaterController, OrderController, QuestionController` (+ `HomeController`) |
| Auth | `AuthController` (login, register + Gmail kody, logout, parol dikeltmek, profil, parol üýtgetmek) |
| CRUD | `WaterController`, `CategoryController` (Create/Read/Update/Delete), `OrderController`, `QuestionController` |
| Validation | Hemme `store/update` içinde `$request->validate(...)`; model içinde `validationRules()` |
| Relationships | `User hasMany Orders/Questions`, `Category hasMany Waters`, `Water belongsTo Category / hasMany Orders`, `Order belongsTo User/Water`, `Question belongsTo User` |
| `$table->foreignId()` | `database/migrations/2026_11_07_200000_create_water_factory_tables.php` |
| `whereHas()` | `HomeController`, `CategoryController`, `WaterController`, `OrderController`, `QuestionController` |
| `auth()->user()` | `HomeController@dashboard`, `OrderController`, `QuestionController`, `AuthController@updatePassword` |
| UI / glassmorphism | `public/css/style.css` + `resources/views/**` |
| 3 dil | `lang/tm`, `lang/ru`, `lang/en` (messages + validation), `SetLocale` middleware, TM/RU/EN düwmeleri |
| 10+ route | `routes/web.php` (40 route) |
| Email practice | `VerificationCodeMail` (agza bolanda) + `PasswordResetCodeMail` (paroly unutdym) |
| My questions + answer | `/my-questions`, `/admin/questions` |

## 🧪 Test

```bash
php artisan test
```
