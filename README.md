# iApps API Development

---

#### Run Project First:

---

#### 1) Clone Project

`git clone https://tfs2019.akij.net/WebApplicationCollection/iAppsAPI/_git/iAppsAPI`

#### 2) Update Composer

`composer Update` [Install Composer first if it is not installed, then run this command]

#### 3) Connect Database [if not]

Open/create `.env` file by copying of `.env.example` file and fill the above values

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=DB_NAME
DB_USERNAME=DB_USERNAME
DB_PASSWORD=XXXXXX
```

#### 4) Migrate

Run migration command to migarte into database

```
php artisan migrate
```

#### 5) Run Seeder

```
php artisan db:seed
```

#### 6) Run Project

```
php artisan serve
```

Open browser the URL: http://127.0.0.1:8000/api/documentation

[A swagger will be open up, and check the API's :sunglasses: :sunglasses: :sunglasses: ]

---

#### Develop API From Zero:

---

#### What Technologies

> Please Install this Same Setup in your Local Machine to make a Quick Start...

1. PHP - `7.4.2` [Install Xampp - `7.4.7`]
1. Laravel Framework - `7.25`
1. VS Code Latest Version - Packages(To Code Faster)
    1. PHP Formatter
    1. Laravel intellisense
    1. Laravel Blade Snippets
    1. Laravel Extra Intellisense
    1. Laravel Blade Spacer
    1. Laravel Assist
    1. Prettier+
    1. Bracket Pair Colorizer
1. Composer Packages

#### Used 3rd Party Verfied Packages While Developing

1. Laravel Modules to Make Domain Driven Design: https://nwidart.com/laravel-modules/v6/introduction
1. Laravel Passport Authentication to make secured Oath2 Token Based Server Implementation - https://laravel.com/docs/7.x/passport#introduction
1. To Generate API Documentation Using Swagger - https://github.com/DarkaOnLine/L5-Swagger

#### Code of Conduct

1. Never Trust User. Never trust any of the values/requests from the user.
1. Always Maintain The Architecture, Never Violates. If there is proper suggestion, it's Welcomed.

# API Development

---

#### User Account

-   [ ] **User Account** - @Maniruzzaman Akash
    -   [x] Register User Account
    -   [x] Login
    -   [ ] Forget Password
    -   [x] Profile View
    -   [x] Authenticate API Route
    -   [ ] Social Authentication

#### Business

-   [ ] **Currencies** - @Farid Uddin

    -   [ ] Data Import / Seeder For Currencies Table

-   [ ] **Tax Rate** - @Farid Uddin

    -   [ ] Create Tax Rate
    -   [ ] Edit Tax Rate
    -   [ ] Details Tax Rate
    -   [ ] Delete Tax Rate
    -   [ ] Seeder For Business

-   [ ] **Business** - @Farid Ahmed
    -   [ ] Create Business Account
    -   [ ] Edit Business Account
    -   [ ] Details Business Account
    -   [ ] Delete Business Account
    -   [ ] Seeder For Business

#### Customer

-   [ ] **Customer** - @Farid Uddin

    -   [ ] Create Customer
    -   [ ] Edit Customer
    -   [ ] Details Customer
    -   [ ] Delete Customer
    -   [ ] Seeder For Customers

#### Supplier

-   [ ] **Supplier** - @Farid Uddin
    -   [ ] Create Supplier
    -   [ ] Edit Supplier
    -   [ ] Details Supplier
    -   [ ] Delete Supplier
    -   [ ] Seeder For Suppliers

#### Item

-   [ ] **Brand** - @Monirul Islam

    -   [ ] Create Brand
    -   [ ] Edit Brand
    -   [ ] Details Brand
    -   [ ] Delete Brand
    -   [ ] Seeder For Brands

-   [ ] **Category** - @Monirul Islam

    -   [ ] Create Category
    -   [ ] Edit Category
    -   [ ] Details Category
    -   [ ] Delete Category
    -   [ ] Seeder For Categories

-   [ ] **Unit** - @Monirul Islam

    -   [ ] Create Unit
    -   [ ] Edit Unit
    -   [ ] Details Unit
    -   [ ] Delete Unit
    -   [ ] Seeder For Units

-   [ ] **Item** - @Farid Uddin
    -   [ ] Create Item
    -   [ ] Edit Item
    -   [ ] Details Item
    -   [ ] Delete Item
    -   [ ] Seeder For Items
