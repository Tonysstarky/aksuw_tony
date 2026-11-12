<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Question;
use App\Models\User;
use App\Models\Water;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users - Baş Dolandyryjy: Yusup Gajaýew
        $yusup = User::create([
            'name' => 'Yusup Gajaýew',
            'email' => 'yusup@water.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+993 65 123456',
            'address' => 'Aşgabat ş., Bitaraplyk şaýoly 120, jaý 14',
            'email_verified_at' => now(),
        ]);

        $mugallym = User::create([
            'name' => 'Mugallym Test',
            'email' => 'mugallym@water.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '+993 61 987654',
            'address' => 'Aşgabat ş., 10 ýyl Abadançylyk köçesi 45',
            'email_verified_at' => now(),
        ]);

        // 2. Exact 6 Categories according to user's specification txt:

        // Cat 1: „Arçalyk” kärhanasy (Agyz suwlary, Pöwrize, Arçi, Limonadlar)
        $catArchalyk = Category::create([
            'name_tm' => '„Arçalyk” Kärhanasy (Pöwrize, Arçi, Limonadlar)',
            'name_ru' => 'Предприятие «Арчалык» (Повризе, Арчи, Лимонады)',
            'name_en' => '«Archalyk» Enterprise (Powrize, Archi, Sodas)',
            'description_tm' => 'Pöwrize ýerasty süýji suw ýatagynyň tebigy arassa agyz suwy, Pöwrize gazlandyrylan suw, Arçi naýbaşy premium gazlandyrylan suwlar we Arçalyk nusgawy miweli limonadlary.',
            'description_ru' => 'Природная вода Повризе, газированная вода, премиальные вкусовые воды Арчи и классические фруктовые лимонады Арчалык.',
            'description_en' => 'Pure natural spring water Powrize, sparkling water, Archi premium collection and classic Archalyk fruit lemonades.',
            'icon' => '🏔️',
        ]);

        // Cat 2: «Goşa Çynar» kärhanasy (Suwlar, Kola Çynar, Witaminli, 7 Çynar)
        $catGosaCynar = Category::create([
            'name_tm' => '«Goşa Çynar» Kärhanasy (Suwlar, Kola, 7 Çynar)',
            'name_ru' => 'Предприятие «Гоша Чынар» (Воды, Кола, 7 Чынар)',
            'name_en' => '«Gosha Chynar» Enterprise (Waters, Cola, 7 Chynar)',
            'description_tm' => 'Goşa Çynar emeli minerallaşdyrylan we gazlandyrylan suwlary, Goşa Çynar Kola, Kola Çynar, Witaminli energiýa içgileri we «7 Çynar» miweli limonad seriýasy.',
            'description_ru' => 'Минерализованные и газированные воды Гоша Чынар, Чынар Кола, витаминизированные энергетики и популярные лимонады «7 Чынар».',
            'description_en' => 'Mineralized and carbonated drinking water, Gosha Chynar Cola, Vitamin energy drinks and «7 Chynar» fruit lemonade series.',
            'icon' => '🌳',
        ]);

        // Cat 3: «Teşne» & «Jadyly çeşme» HJ (Änew şäheri, tagamly suwlar, 19L kuler)
        $catTesne = Category::create([
            'name_tm' => '«Teşne» & «Jadyly çeşme» (Tagamly Suwlar, 19L Kuler)',
            'name_ru' => '«Тешне» и «Джадылы чешме» (Вкусовые воды, 19L Кулер)',
            'name_en' => '«Teshne» & «Jadyly cheshme» (Flavored waters, 19L)',
            'description_tm' => 'Ak bugdaý etrabynda öndürilýän Teşne şetdaly, limon, alma, ýertudana, garpyz tagamly suwlary, Kewser, Gurt, Tut, Red Tut we 19L kuler eltip bermek hyzmaty.',
            'description_ru' => 'Вкусовые воды Тешне (персик, лимон, яблоко, клубника, арбуз), напитки Кевсер, Тут, Ред Тут и доставка 19-литровых кулерных бутылей.',
            'description_en' => 'Teshne flavored waters (peach, lemon, apple, strawberry, watermelon), Kewser, Tut, Red Tut and 19-liter dispenser water delivery.',
            'icon' => '💧',
        ]);

        // Cat 4: "The Coca-Cola Company" (AÝRATYN KATEGORIÝA: Classic, Zero, Fanta, Sprite, Bonaqua, Schweppes, Cappy, FuseTea)
        $catCocaCola = Category::create([
            'name_tm' => 'The Coca-Cola Company (Kola, Fanta, Sprite, Bonaqua)',
            'name_ru' => 'The Coca-Cola Company (Кола, Фанта, Спрайт, Бонаква)',
            'name_en' => 'The Coca-Cola Company (Cola, Fanta, Sprite, Bonaqua)',
            'description_tm' => 'Coca-Cola Classic, Coca-Cola Zero Sugar / Light, Fanta mäşrep/pyrtykal, Sprite serginlediji dury gazly içgi, Bonaqua arassa agyz suwy, Schweppes tonik, Cappy miwe şireleri we FuseTea sowuk çaýlary.',
            'description_ru' => 'Coca-Cola Classic, Zero Sugar, Fanta, Sprite, питьевая вода Bonaqua, тоник Schweppes, соки Cappy и холодный чай FuseTea.',
            'description_en' => 'World-famous beverages: Coca-Cola Classic, Zero Sugar, Fanta, Sprite, Bonaqua drinking water, Schweppes tonic, Cappy juices and FuseTea.',
            'icon' => '🥤',
        ]);

        // Cat 5: Lipton Sowuk Çaýlary (AÝRATYN KATEGORIÝA: Green Tea, Black Tea, Tropical, Zero)
        $catLipton = Category::create([
            'name_tm' => 'Lipton Sowuk Çaýlary (Ice Tea Green, Black, Zero)',
            'name_ru' => 'Холодный Чай Lipton (Зеленый, Черный, Зеро)',
            'name_en' => 'Lipton Ice Tea (Green Tea, Black Tea, Zero)',
            'description_tm' => 'Lipton Green Lemon, Green Peach, Green Strawberry, Gara çaý (Lipton Peach, Lemon, Raspberry, Mango), Tropiki miweler we Lipton Zero Sugar şekersiz seriýasy.',
            'description_ru' => 'Натуральные холодные чаи Lipton: зеленый чай (лимон, клубника, цитрус), черный чай (персик, малина, манго) и линейка Zero Sugar без сахара.',
            'description_en' => 'Lipton iced teas: Green tea varieties (lemon, peach, strawberry), Black tea line (peach, lemon, raspberry, mango), Tropical and Zero Sugar editions.',
            'icon' => '🍋',
        ]);

        // Cat 6: Red Bull Energetiki Içgileri (Original, Sugarfree, Red/Blue/Yellow/Green Editions)
        $catRedBull = Category::create([
            'name_tm' => 'Red Bull Energetiki Içgileri (Original & Editions)',
            'name_ru' => 'Энергетические Напитки Red Bull (Original & Editions)',
            'name_en' => 'Red Bull Energy Drinks (Original & Editions)',
            'description_tm' => 'Red Bull Energy Drink, Red Bull Sugarfree, Red Bull Zero we ýörite Red Bull Editions seriýasy (The Red Garbyz, The Blue Blueberry, The Yellow Tropical, The Green Kiwi).',
            'description_ru' => 'Энергетики Red Bull: оригинальный, Sugarfree, Zero и вкусовые линейки Red Bull Editions (арбуз, черника, тропик, киви-яблоко).',
            'description_en' => 'Red Bull Energy Drink, Sugarfree, Zero and colorful Red Bull Editions (The Red Watermelon, The Blue Blueberry, The Yellow Tropical, The Green Kiwi-Apple).',
            'icon' => '⚡',
        ]);

        // 3. Exact Waters & Drinks listed in user's text with high-resolution imagery:

        // ==================== SECTION 1: ARÇALYK KÄRHANASY ====================
        Water::create([
            'category_id' => $catArchalyk->id,
            'name' => 'Arçalyk Gazlandyrylmadyk Tebigy Agyz Suwy 1.5L',
            'volume' => '1.5L',
            'price' => 4.50,
            'stock' => 850,
            'ph_level' => '7.4 pH',
            'mineral_content' => 'Pöwrize ýerasty süýji suw çeşmesi, Ca: 48 mg/L, Mg: 18 mg/L, TDS: 220 mg/L',
            'image' => 'https://images.unsplash.com/photo-1548839140-29a749e1bc4e?w=800&auto=format&fit=crop&q=80',
            'description' => '„Arçalyk” kärhanasynyň Pöwrize ýerasty süýji suw ýatagyndan alynýan tebigy agyz suwy. Gündelik içmäge iň peýdaly we ýakymly suw.',
        ]);

        Water::create([
            'category_id' => $catArchalyk->id,
            'name' => 'Arçalyk Tebigy Agyz Suwy 0.5L',
            'volume' => '0.5L',
            'price' => 2.50,
            'stock' => 900,
            'ph_level' => '7.4 pH',
            'mineral_content' => 'Pöwrize çeşme suwy, amatly göwrüm',
            'image' => 'https://images.unsplash.com/photo-1595994195534-d5219f02f99f?w=800&auto=format&fit=crop&q=80',
            'description' => 'Gündelik ýoluňyzda, sportda we iş ýeriňizde ýanyňyzda götermäge amatly 0.5 litrlik Arçalyk tebigy agyz suwy.',
        ]);

        Water::create([
            'category_id' => $catArchalyk->id,
            'name' => 'Pöwrize Gazlandyrylan Agyz Suwy 0.5L',
            'volume' => '0.5L',
            'price' => 3.50,
            'stock' => 600,
            'ph_level' => '7.1 pH',
            'mineral_content' => 'Tebigy mineral gazy, Pöwrize arassa suwy',
            'image' => 'https://images.unsplash.com/photo-1523362628745-0c100150b504?w=800&auto=format&fit=crop&q=80',
            'description' => 'Pöwrize — gazlandyrylan adaty agyz suwy. Aşgazan-içege we iýmit siňdiriş saglygy üçin tebigy gazly dury agyz suwy.',
        ]);

        Water::create([
            'category_id' => $catArchalyk->id,
            'name' => 'Arçi Greýpfrut Premium Gazlandyrylan 0.25L',
            'volume' => '0.25L',
            'price' => 5.00,
            'stock' => 450,
            'ph_level' => '6.5 pH',
            'mineral_content' => 'Tebigy greýpfrut şiresi, premium mineral suw',
            'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=800&auto=format&fit=crop&q=80',
            'description' => '«Arçi» naýbaşy premium derejeli gazlandyrylan suw seriýasy (0.25L gapda). Greýpfrut tagamly ter we serginlediji lezzet.',
        ]);

        Water::create([
            'category_id' => $catArchalyk->id,
            'name' => 'Arçi Mohito & Aloe Premium 0.25L',
            'volume' => '0.25L',
            'price' => 5.00,
            'stock' => 420,
            'ph_level' => '6.4 pH',
            'mineral_content' => 'Laým, narpyz we aloe ekstraktlary',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=800&auto=format&fit=crop&q=80',
            'description' => 'Ýörite tagamly Arçi Mohito & Aloe naýbaşy gazlandyrylan premium suw. Tomus günlerinde teşneligi dessine gandyryjy.',
        ]);

        Water::create([
            'category_id' => $catArchalyk->id,
            'name' => 'Arçalyk Armyt (Дюшес) & Pyrtykal Limonady 0.5L',
            'volume' => '0.5L',
            'price' => 4.00,
            'stock' => 600,
            'ph_level' => '5.8 pH',
            'mineral_content' => 'Pöwrize arassa suwy, tebigy armyt we pyrtykal şerbedi',
            'image' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=800&auto=format&fit=crop&q=80',
            'description' => 'Arçalyk kärhanasynyň nusgawy Armyt (Дюшес) we Pyrtykal miweli gazlandyrylan limonady. Pöwrize arassa suwundan taýýarlanylýar.',
        ]);

        Water::create([
            'category_id' => $catArchalyk->id,
            'name' => 'Arçalyk Tarhun & Zirk (Barbaris) 0.5L',
            'volume' => '0.5L',
            'price' => 4.00,
            'stock' => 500,
            'ph_level' => '5.9 pH',
            'mineral_content' => 'Estragon (tarhun) we zirk tagamly salkyn içgi',
            'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&auto=format&fit=crop&q=80',
            'description' => 'Arçalyk fabriginiň meşhur Tarhun, Zirk, Buratino we Tokaý miweleri tagamly süýji gazlandyrylan limonadlary.',
        ]);

        // ==================== SECTION 2: GOŞA ÇYNAR ====================
        Water::create([
            'category_id' => $catGosaCynar->id,
            'name' => 'Goşa Çynar Emeli Minerallaşdyrylan Suw 1.5L',
            'volume' => '1.5L',
            'price' => 4.00,
            'stock' => 750,
            'ph_level' => '7.2 pH',
            'mineral_content' => 'ISO 9001 sertifikatly, minerallaşdyrylan agyz suwy',
            'image' => 'https://images.unsplash.com/photo-1550572017-ed200f5e6343?w=800&auto=format&fit=crop&q=80',
            'description' => '«Goşa Çynar» kärhanasynyň emeli minerallaşdyrylan gazlandyrylan we gazsyz arassa agyz suwy.',
        ]);

        Water::create([
            'category_id' => $catGosaCynar->id,
            'name' => 'Goşa Çynar Kola / Kola Çynar 1.0L',
            'volume' => '1.0L',
            'price' => 6.50,
            'stock' => 680,
            'ph_level' => '3.0 pH',
            'mineral_content' => 'Klassiki kola tagamy, arassa çeşme suwy',
            'image' => 'https://images.unsplash.com/photo-1553456558-aff63285bdd1?w=800&auto=format&fit=crop&q=80',
            'description' => 'Goşa Çynar kärhanasynyň öndürýän milli Kola Çynar içgisi. Saçak bezegi we myhmançylyk üçin ajaýyp tagam.',
        ]);

        Water::create([
            'category_id' => $catGosaCynar->id,
            'name' => 'Goşa Çynar Witamin / Zirk Energetik 400ml',
            'volume' => '0.4L',
            'price' => 5.50,
            'stock' => 450,
            'ph_level' => '3.4 pH',
            'mineral_content' => 'Kafein, B toparyň witaminleri, zirk (barbaris) tagamy',
            'image' => 'https://images.unsplash.com/photo-1527661591475-527312dd65f5?w=800&auto=format&fit=crop&q=80',
            'description' => 'Goşa Çynar kafeinli energiýa içgisi we zirk tagamly witaminleşdirilen salkynlaşdyryjy içgi.',
        ]);

        Water::create([
            'category_id' => $catGosaCynar->id,
            'name' => '7 Çynar Tarhun, Limon & Pyrtykal 1.0L',
            'volume' => '1.0L',
            'price' => 5.00,
            'stock' => 550,
            'ph_level' => '5.6 pH',
            'mineral_content' => '«7 Çynar» seriýasy, tebigy miwe tagamlary',
            'image' => 'https://images.unsplash.com/photo-1595994195534-d5219f02f99f?w=800&auto=format&fit=crop&q=80',
            'description' => '«7 Çynar» seriýasyndan Tarhun, Limonad we Pyrtykal (apelsin) tagamly miweli süýji gazlandyrylan limonadlar.',
        ]);

        // ==================== SECTION 3: TEŞNE & JADYLY ÇEŞME ====================
        Water::create([
            'category_id' => $catTesne->id,
            'name' => 'Teşne Şetdaly & Limon Tagamly Suw 0.5L',
            'volume' => '0.5L',
            'price' => 3.00,
            'stock' => 880,
            'ph_level' => '7.2 pH',
            'mineral_content' => 'Tebigy çeşme suwy, şetdaly we limon ekstraktlary',
            'image' => 'https://images.unsplash.com/photo-1560023907-5f339617ea30?w=800&auto=format&fit=crop&q=80',
            'description' => '«Jadyly çeşme» hojalyk jemgyýetiniň (Ak bugdaý etrabynyň Änew şäheri) öndürýän Teşne şetdaly we limon tagamly suwy.',
        ]);

        Water::create([
            'category_id' => $catTesne->id,
            'name' => 'Teşne Alma, Garpyz & Ýertudana 0.5L',
            'volume' => '0.5L',
            'price' => 3.00,
            'stock' => 800,
            'ph_level' => '7.3 pH',
            'mineral_content' => 'Tebigy alma, garpyz we klubnika tagamlary',
            'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=800&auto=format&fit=crop&q=80',
            'description' => 'Teşne ýeňil gazlandyrylan miwe tagamly suwlary: Alma, garpyz we ýertudana. Tomusda teşneligi gandyrmak üçin amatly.',
        ]);

        Water::create([
            'category_id' => $catTesne->id,
            'name' => 'Kewser, Tut & Red Tut Salkyn Içgisi 0.5L',
            'volume' => '0.5L',
            'price' => 4.00,
            'stock' => 520,
            'ph_level' => '6.2 pH',
            'mineral_content' => '«Jadyly çeşme» HJ nyşanlary: Kewser, Tut, Red Tut, Belle',
            'image' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=800&auto=format&fit=crop&q=80',
            'description' => '«Jadyly çeşme» HJ-niň Kewser, Gurt, Belle, Tut we Red Tut haryt nyşanly salkynlaşdyryjy içgileri.',
        ]);

        $coolerWater = Water::create([
            'category_id' => $catTesne->id,
            'name' => 'Teşne & Jadyly Çeşme 19L Kuler Suwy',
            'volume' => '19.0L',
            'price' => 16.00,
            'stock' => 350,
            'ph_level' => '7.4 pH',
            'mineral_content' => '19 litrlik gaplarda sargyt esnasynda arassa agyz suwuny eltip bermek hyzmaty',
            'image' => 'https://images.unsplash.com/photo-1559839914-ba2ac6d7c997?w=800&auto=format&fit=crop&q=80',
            'description' => 'Öýlere we ofislere 19 litrlik gaplarda sargyt esnasynda arassa agyz suwuny gapyňyza çenli eltip bermek hyzmaty.',
        ]);

        // ==================== SECTION 4: THE COCA-COLA COMPANY ====================
        Water::create([
            'category_id' => $catCocaCola->id,
            'name' => 'Coca-Cola Classic TM 1.0L',
            'volume' => '1.0L',
            'price' => 12.00,
            'stock' => 650,
            'ph_level' => '2.5 pH',
            'mineral_content' => 'The Coca-Cola Company nusgawy formulasy',
            'image' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=800&auto=format&fit=crop&q=80',
            'description' => 'Kompaniýanyň iň esasy we bütindünýä belli nusgawy gazly içgisi. Saçak bezegi we toý-baýramlar üçin hemişe birinji saýlaw.',
        ]);

        Water::create([
            'category_id' => $catCocaCola->id,
            'name' => 'Coca-Cola Zero Sugar (Şekersiz) 0.5L',
            'volume' => '0.5L',
            'price' => 7.50,
            'stock' => 480,
            'ph_level' => '2.8 pH',
            'mineral_content' => 'Şeker goşulmadyk, 0 kaloriýa, berhiz saklaýanlar üçin',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=800&auto=format&fit=crop&q=80',
            'description' => 'Şeker goşulmadyk Coca-Cola Zero Sugar / Light. Hakyky kola tagamy, nol kaloriýa.',
        ]);

        Water::create([
            'category_id' => $catCocaCola->id,
            'name' => 'Fanta Pyrtykal & Sprite Limon-Laým 1.0L',
            'volume' => '1.0L',
            'price' => 11.50,
            'stock' => 520,
            'ph_level' => '3.2 pH',
            'mineral_content' => 'Fanta tebigy apelsin / Sprite serginlediji dury limon-laým',
            'image' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=800&auto=format&fit=crop&q=80',
            'description' => 'Fanta mäşrep/pyrtykal tagamly meşhur gazly içgi we Sprite serginlediji dury gazly içgi.',
        ]);

        Water::create([
            'category_id' => $catCocaCola->id,
            'name' => 'Bonaqua Arassa Agyz Suwy 1.5L',
            'volume' => '1.5L',
            'price' => 5.00,
            'stock' => 580,
            'ph_level' => '7.2 pH',
            'mineral_content' => '"The Coca-Cola Company" tarapyndan gaplanýan agyz suwy markasy',
            'image' => 'https://images.unsplash.com/photo-1548839140-29a749e1bc4e?w=800&auto=format&fit=crop&q=80',
            'description' => 'Bonaqua — "The Coca-Cola Company" tarapyndan öndürilýän we gaplanýan arassa agyz suwy markasy.',
        ]);

        Water::create([
            'category_id' => $catCocaCola->id,
            'name' => 'Cappy Miwe Şiresi, Schweppes & FuseTea 1.0L',
            'volume' => '1.0L',
            'price' => 14.00,
            'stock' => 400,
            'ph_level' => '3.5 pH',
            'mineral_content' => 'Cappy miwe şiresi, Schweppes tonik, FuseTea sowuk çaý',
            'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=800&auto=format&fit=crop&q=80',
            'description' => 'Cappy tebigy miwe şiresi, Schweppes gazly mineral tonik suwy we FuseTea sowuk çaý (Ice Tea).',
        ]);

        // ==================== SECTION 5: LIPTON ICE TEA ====================
        Water::create([
            'category_id' => $catLipton->id,
            'name' => 'Lipton Green Lemon, Peach & Citrus Ýaşyl Çaý 0.5L',
            'volume' => '0.5L',
            'price' => 8.50,
            'stock' => 480,
            'ph_level' => '3.4 pH',
            'mineral_content' => 'Tebigy ýaşyl çaý ekstrakty, ter limon we sitrus miweleri',
            'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&auto=format&fit=crop&q=80',
            'description' => '🟢 Ýaşyl çaýlar (Green Tea): Lipton Green Lemon, Green Peach, Green Strawberry we Green Tea Citrus.',
        ]);

        Water::create([
            'category_id' => $catLipton->id,
            'name' => 'Lipton Peach (Şetdaly) Gara Çaý 0.5L',
            'volume' => '0.5L',
            'price' => 8.00,
            'stock' => 550,
            'ph_level' => '3.5 pH',
            'mineral_content' => 'Gara çaý ekstrakty we tebigy şetdaly şiresi',
            'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&auto=format&fit=crop&q=80',
            'description' => '🟤 Gara çaýlar (Black Tea): Lipton Peach — iň meşhurlarynyň biri. Şetdaly tagamly ter gara çaý lezzeti.',
        ]);

        Water::create([
            'category_id' => $catLipton->id,
            'name' => 'Lipton Raspberry, Mango & Berries 0.5L',
            'volume' => '0.5L',
            'price' => 8.50,
            'stock' => 410,
            'ph_level' => '3.5 pH',
            'mineral_content' => 'Malina (raspberry), mango ekzotik we gyzyl tokaý miweleri',
            'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&auto=format&fit=crop&q=80',
            'description' => '🔴 Tropiki we Garasuw görnüşleri: Lipton Raspberry, Mango Exotic, Red Fruits/Berries we Watermelon & Melon.',
        ]);

        Water::create([
            'category_id' => $catLipton->id,
            'name' => 'Lipton Zero Sugar Lemon & Peach 0.5L',
            'volume' => '0.5L',
            'price' => 8.50,
            'stock' => 350,
            'ph_level' => '3.4 pH',
            'mineral_content' => '⚪ Şekersiz görnüşler (Zero Sugar / Light)',
            'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&auto=format&fit=crop&q=80',
            'description' => '⚪ Şekersiz görnüşler: Lipton Zero Sugar Lemon, Zero Sugar Peach we Zero Sugar Tropical.',
        ]);

        // ==================== SECTION 6: RED BULL ENERGETIKI IÇGILERI ====================
        Water::create([
            'category_id' => $catRedBull->id,
            'name' => 'Red Bull Energy Drink (Original) 250ml',
            'volume' => '0.25L',
            'price' => 18.00,
            'stock' => 550,
            'ph_level' => '3.3 pH',
            'mineral_content' => 'Taurin, kafein, B toparyň witaminleri (B3, B5, B6, B12)',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=800&auto=format&fit=crop&q=80',
            'description' => 'Red Bull Energy Drink: Adaty we iň köp ýaýran original görnüşi (gök we kümüş reňkli çelekde).',
        ]);

        Water::create([
            'category_id' => $catRedBull->id,
            'name' => 'Red Bull Sugarfree & Zero 250ml',
            'volume' => '0.25L',
            'price' => 18.00,
            'stock' => 380,
            'ph_level' => '3.4 pH',
            'mineral_content' => 'Şekersiz we kaloriýasyz Red Bull formulasy',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=800&auto=format&fit=crop&q=80',
            'description' => 'Red Bull Sugarfree (şekersiz, kaloriýasyz) we Red Bull Zero (şekersiz we uglewodsyz görnüşi).',
        ]);

        Water::create([
            'category_id' => $catRedBull->id,
            'name' => 'Red Bull The Red Edition (Garbyz) 250ml',
            'volume' => '0.25L',
            'price' => 20.00,
            'stock' => 320,
            'ph_level' => '3.3 pH',
            'mineral_content' => 'Tebigy ter garbyz (Watermelon) tagamly energetik',
            'image' => 'https://images.unsplash.com/photo-1527661591475-527312dd65f5?w=800&auto=format&fit=crop&q=80',
            'description' => 'Red Bull Editions: The Red Edition — Garbyz (Watermelon) tagamly ýörite gyzyl seriýa.',
        ]);

        Water::create([
            'category_id' => $catRedBull->id,
            'name' => 'Red Bull The Blue & Yellow Edition (Tropical) 250ml',
            'volume' => '0.25L',
            'price' => 20.00,
            'stock' => 310,
            'ph_level' => '3.3 pH',
            'mineral_content' => 'Blueberry (gök nyr) we tropiki miweler tagamy',
            'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=800&auto=format&fit=crop&q=80',
            'description' => 'The Blue Edition (Gök nyr / Blueberry) we The Yellow Edition (Tropiki miweler tagamy / Tropical).',
        ]);

        // 4. Sample Orders
        Order::create([
            'user_id' => $yusup->id,
            'water_id' => $coolerWater->id,
            'quantity' => 5,
            'total_price' => 80.00,
            'delivery_address' => 'Aşgabat ş., Bitaraplyk şaýoly 120, jaý 14',
            'phone' => '+993 65 123456',
            'notes' => '3-nji gat, lift bar. Yusup Gajaýew üçin sargyt.',
            'status' => 'processing',
        ]);

        // 5. Sample Questions
        Question::create([
            'user_id' => $yusup->id,
            'name' => 'Yusup Gajaýew',
            'email' => 'yusup@water.com',
            'phone' => '+993 65 123456',
            'subject' => 'Arçalyk, Teşne we Goşa Çynar suwlarynyň lomaý eltip bermek hyzmaty',
            'message' => 'Salam! Dükan üçin her hepde 300 blok Teşne, Arçalyk we Goşa Çynar suwlaryny sargyt etsek lomaý arzanlaşyk barmy?',
            'answer' => 'Salam hormatly Yusup Gajaýew! Hawa, dükanlar we edaralar üçin lomaý arzanlaşyk we şol günüň özünde mugt eltip bermek hyzmatymyz hereket edýär.',
            'status' => 'answered',
        ]);

        Question::create([
            'user_id' => $mugallym->id,
            'name' => 'Mugallym Test',
            'email' => 'mugallym@water.com',
            'phone' => '+993 61 987654',
            'subject' => '19L Kuler gaplary näçe sagatda gowşurylýar?',
            'message' => 'Salam, Aşgabat şäherine 19 litrlik kuler suwy sargyt etsek haçan eltip berip bilersiňiz?',
            'answer' => 'Salam hormatly Mugallym! Sargydyňyz tassyklanandan soň 2 sagadyň içinde gapyňyza gowşurylýar.',
            'status' => 'answered',
        ]);
    }
}
