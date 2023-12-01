# <span id = "ua">Pulse</span>
## Зміст
- <a href = "#ua">Українська версія документації</a>
    - <a href = "#descrUa">Опис проєкту</a>
    - <a href = "#mainFooUa">Основні функції</a>
    - <a href = "#eventListenersUa">Прослуховування та обробка подій</a>
    - <a href = "#animsUa">Анімації</a>
- <a href = "#en">English version of the documentation</a>
    - <a href = "#descrEn">Project description</a>
    - <a href = "#mainFooEn">Main functions</a>
    - <a href = "#eventListenersEn">Event Listeners and Event Handling</a>
    - <a href = "#animsEn">Animations</a>

## <span id = "descrUa">Опис проєкту</span>
Це проєкт лендінг сторінки-магазину товарів. Приклад того, як можна продавати свої товари, не маючи повноцінного сайту інтернет-магазину, а тільки лендінг сторінку з основними товарами, та форму замовлення, яка відправляє інформацію на сервер, де буде оброблятись замовлення клієнта.
Програмна частина цього проєкту використовує Jquery та кілька додаткових бібліотек на основі нього: <a href="https://github.com/digitalBush/jquery.maskedinput">jquery.maskedinput</a>, <a href = "https://jqueryvalidation.org/">jQuery Validation Plugin</a>, також бібліотеки на нативному js: <a href = "https://github.com/ganlanyuan/tiny-slider">tiny-slider</a>, <a href="https://wowjs.uk/">wow.js</a>. Розглянемо основні складові, які дозволяють взаємодіяти зі сторінкою.
## <span id="mainFooUa">Основні функції</span>
### `function toggleSlide(item)`
Функція додає прослуховувачі на кнопки перемикання додаткового опису та кнопки назад, яка приховує додатковий опис товару.
### `function validateForm (form)`
Функція у собі ініціалізує тимчасовий екземпляр валідатора, та валідує передану форму. Повертає результат валідації.
## <span id = "eventListenersUa">Прослуховування та обробка подій</span>
### Поява вікна з формою для замовлення консультації
``` javascript
    $('[data-modal=consultation]').on('click', function() {
        $('.overlay, #consultation').fadeIn('slow');
    });
```
Прослуховується клік на кнопку "Замовити дзвінок", відкривається вікно з формою консультації.
### Приховування вікна з формою для замовлення консультації
``` javascript
    $('.modal__close').on('click', function() {
        $('.overlay, #consultation, #buy-done, #buy').fadeOut('slow');
    });
```
Прослуховується клік на хрестик для закриття вікна та закривається вікно.
### Додавання назви товару у вікно замовлення консультації
```javascript
    $('.button_product-card').each(function(i) {
        $(this).on('click', function() {
            $('#buy .modal__subtitle').text($('.product-card__title').eq(i).text());
            $('.overlay, #buy').fadeIn('slow');
        })
    });
```
Для кожної кнопки "Купити" у карточці товару додається прослуховування кліку. Після кліку, у вікно з формою замовлення консультації додається назва товару, який хочуть купити, та відкривається це вікно.
### Перемикання табів
```javascript
      $('ul.catalog__tabs-list').on('click', 'li:not(.catalog__tab-active)', function() {
        $(this)
          .addClass('catalog__tab-active').siblings().removeClass('catalog__tab-active')
          .closest('div.catalog__tabs').find('div.catalog__tabs-content').removeClass('catalog__tabs-content-active').eq($(this).index()).addClass('catalog__tabs-content-active');
      });
```
Прослуховується клік на елементи табів, окрім активного табу. Закривається\відкривається відповідний список карточок товарів, який відноситься до того, чи іншого табу.
### Форматування номера телефону у формі
```javascript
$("input[name=telephone]").mask("+380 (99)-999-99-99");
```
До інпуту `input[name=telephone]` застосовується метод для форматування номера телефона за українським національним форматом "+380 (99)-999-99-99". Це не прослуховування подій у звичному розумінні цього терміну. Але за характером роботи бібліотеки jquery.maskedinput, здається, всередині себе вона прослуховує введення в інпут, для форматування номера, тому я відніс це до прослуховувачів подій.
### Перемикання слайдів у слайдері
```javascript
document.querySelector('.slider__prev-button').addEventListener('click', function () {
    slider.goTo('prev');
  });

document.querySelector('.slider__next-button').addEventListener('click', function () {
    slider.goTo('next');
  });
```
Прослуховуються кнопки для перемикання слайдеру "наступний слайд" та "минулий слайд", переключаються слайди у відповідному напрямку.
### Поява\зникнення кнопки повернення до початку сторінки
```javascript
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1600) {
            $('.to-top').fadeIn();
        } else {
            $('.to-top').fadeOut();
        }
    });
```
Перевірка позиції області перегляду на сторінці, якщо перегляд сторінки підходить до кінця, то з'являється кнопка прокрутки сторінки до початку, якщо ні - кнопка зникає.
### Валідація та відправка даних користувача на сервер
```javascript
    $("form").submit(function (e) {
        e.preventDefault();
        if(validateForm(this) === true) {
            $('.client-form__loading').fadeIn();
        $.ajax({
            type: "POST",
            url: "mailer/smart.php",
            data: $(this).serialize()
        }).done(function () {
            $(this).find("input").val("");
            $("form").trigger("reset");

            $('.client-form__loading').fadeOut();
            $(".overlay .modal").fadeOut('slow');
            $(".overlay, #buy-done").fadeIn('slow');
        })
        }
        return false;
    });
```
При підтвердженні відправки форми валідуються дані користувача, якщо все добре, то дані серіалізуються, та відправляються на сервер. Форма скидається, зникає вікно з формою, та з'являється вікно, що замовлення відбулось успішно.
## <span id = "animsUa">Анімації</span>
### Плавний перехід до розділів
```javascript 
    $("a").click(function(){
        const _href = $(this).attr("href");
        $("html, body").animate({scrollTop: $(_href).offset().top+"px"});
        return false;
    });
```
Прослуховується клік на усіх посиланнях, якщо посилання веде до певного елементу на сторінці, то перехід до нього анімується плавною прокруткою на позицію до цього елементу.
### Анімовані іконки
```javascript
    function advantagesImgAnim (entries, observer) {
        entries.forEach((entry)=>{
            if(entry.isIntersecting) {
                advantagesImgs.forEach((elem)=>{
                    if(elem.className !== 'viewed') {
                        elem.classList.add('viewed');
                    }
                });
            }
        });
    }
    
    const advantagesSect = document.querySelector('.advantages');
    const advantagesImgs = document.querySelectorAll('.advantages img');
    const observer = new IntersectionObserver(advantagesImgAnim, {
        threshold: 0.8,
    });
    
    observer.observe(advantagesSect);
```
``` css
    @keyframes run {
        from { 
            transform: translate(0px, 0px);
        }

        33% {
            transform: translate(-10px, 15px);
        }
        66% {
            transform: translate(20px, 15px);
        }
        to {
            transform: translate(0px, 0px);
        }
    }
    &:nth-child(3) {
        .viewed {
            animation: run 1s 4;
        }
    }
```
Завдяки Intersection Observer API ми обробляємо подію, коли секцію `.advantages` бачить користувач, та додаємо класи перегляду усім іконкам, запускаючи анімацію саме тоді, коли користувач бачить іконки. Анімація іконок реалізована завдяки CSS3. Вище наводжу приклад анімації іконки з бігучим кросівком.
### Анімовані появи розділів
```javascript
    new WOW().init();
```
Ініціалізація бібліотеки wow.js.
``` html
    <div class="product-card wow animate__animated animate__fadeInLeft"> ... </div>

    <div class="reviews__review-block wow animate__fadeInUp animate__animated"> ... </div>
```
Застосування бібліотеки до елементів сторінки. Таким чином, анімуємо появу певних елементів, зазначеним чином.


# <span id = "en">Pulse</span>

## <span id = "descrEn">Project description</span>
This is a landing page project for selling goods. It demonstrates how to sell products without a full-fledged e-commerce website, using only a landing page with essential products and an order form. The software part of this project uses jQuery and several additional libraries based on it:  <a href="https://github.com/digitalBush/jquery.maskedinput">jquery.maskedinput</a>, <a href = "https://jqueryvalidation.org/">jQuery Validation Plugin</a>, as well as native JS libraries: <a href = "https://github.com/ganlanyuan/tiny-slider">tiny-slider</a>, <a href="https://wowjs.uk/">wow.js</a>. Let's explore the main components that allow interaction with the page.

## <span id="mainFooEn">Main functions</span>
### `function toggleSlide(item)`
This function adds event listeners to toggle additional description buttons and back buttons that hide the additional product description.
### `function validateForm (form)`
This function initializes a temporary validator instance and validates the passed form. It returns the validation result.

## <span id = "eventListenersEn">Event Listeners and Event Handling</span>

### Displaying the consultation order form window
``` javascript
    $('[data-modal=consultation]').on('click', function() {
        $('.overlay, #consultation').fadeIn('slow');
    });
```
Listens for a click on the "Order a Call" button and opens the consultation form window.
### Hiding the consultation order form window
``` javascript
    $('.modal__close').on('click', function() {
        $('.overlay, #consultation, #buy-done, #buy').fadeOut('slow');
    });
```
Listens for a click on the close button ('X') and closes the window.
### Adding the product name to the consultation order form
```javascript
    $('.button_product-card').each(function(i) {
        $(this).on('click', function() {
            $('#buy .modal__subtitle').text($('.product-card__title').eq(i).text());
            $('.overlay, #buy').fadeIn('slow');
        })
    });
```
For each "Buy" button in the product card, adds a click event listener. After clicking, adds the name of the product the user wants to buy to the consultation order form window and opens the window.
### Tabs switching
```javascript
      $('ul.catalog__tabs-list').on('click', 'li:not(.catalog__tab-active)', function() {
        $(this)
          .addClass('catalog__tab-active').siblings().removeClass('catalog__tab-active')
          .closest('div.catalog__tabs').find('div.catalog__tabs-content').removeClass('catalog__tabs-content-active').eq($(this).index()).addClass('catalog__tabs-content-active');
      });
```
Listens for clicks on tab elements (except the active tab). Closes/opens the corresponding product card list associated with that tab.
### Phone number formatting in the form
```javascript
$("input[name=telephone]").mask("+380 (99)-999-99-99");
```
Applies a method to format the phone number in the `input[name=telephone]` according to the Ukrainian national format "+380 (99)-999-99-99". While not traditional event listening, it uses the nature of the jquery.maskedinput library to format the input as users type.
### Slider slide switching
```javascript
document.querySelector('.slider__prev-button').addEventListener('click', function () {
    slider.goTo('prev');
  });

document.querySelector('.slider__next-button').addEventListener('click', function () {
    slider.goTo('next');
  });
```
Listens for clicks on the "previous slide" and "next slide" buttons and switches slides accordingly.
### Appearance/disappearance of the scroll-to-top button
```javascript
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1600) {
            $('.to-top').fadeIn();
        } else {
            $('.to-top').fadeOut();
        }
    });
```
Checks the scroll position on the page. If the scroll position is past 1600 pixels, the scroll-to-top button appears; otherwise, it disappears.
### Validation and submission of user data to the server
```javascript
    $("form").submit(function (e) {
        e.preventDefault();
        if(validateForm(this) === true) {
            $('.client-form__loading').fadeIn();
        $.ajax({
            type: "POST",
            url: "mailer/smart.php",
            data: $(this).serialize()
        }).done(function () {
            $(this).find("input").val("");
            $("form").trigger("reset");

            $('.client-form__loading').fadeOut();
            $(".overlay .modal").fadeOut('slow');
            $(".overlay, #buy-done").fadeIn('slow');
        })
        }
        return false;
    });
```
When the form submission is confirmed, it validates user data. If successful, it serializes the data and sends it to the server. The form resets, the form window disappears, and a success window appears.
## <span id="animsEn">Animations</span>
### Smooth transition to sections
```javascript 
    $("a").click(function(){
        const _href = $(this).attr("href");
        $("html, body").animate({scrollTop: $(_href).offset().top+"px"});
        return false;
    });
```
Listens for clicks on all links. If a link leads to a specific element on the page, it animates a smooth scroll to that element.
### Animated Icons
```javascript
    function advantagesImgAnim (entries, observer) {
        entries.forEach((entry)=>{
            if(entry.isIntersecting) {
                advantagesImgs.forEach((elem)=>{
                    if(elem.className !== 'viewed') {
                        elem.classList.add('viewed');
                    }
                });
            }
        });
    }
    
    const advantagesSect = document.querySelector('.advantages');
    const advantagesImgs = document.querySelectorAll('.advantages img');
    const observer = new IntersectionObserver(advantagesImgAnim, {
        threshold: 0.8,
    });
    
    observer.observe(advantagesSect);
```
``` css
    @keyframes run {
        from { 
            transform: translate(0px, 0px);
        }

        33% {
            transform: translate(-10px, 15px);
        }
        66% {
            transform: translate(20px, 15px);
        }
        to {
            transform: translate(0px, 0px);
        }
    }
    &:nth-child(3) {
        .viewed {
            animation: run 1s 4;
        }
    }
```
Uses the Intersection Observer API to handle the event when the user sees the `.advantages` section. Adds viewing classes to all icons, triggering the animation when the user sees the icons. Icon animation is implemented using CSS3. The CSS snippet provides an example of an animated icon with a running shoe.
### Animated section appearances
```javascript
    new WOW().init();
```
Initializes the wow.js library.
``` html
    <div class="product-card wow animate__animated animate__fadeInLeft"> ... </div>

    <div class="reviews__review-block wow animate__fadeInUp animate__animated"> ... </div>
```
Applies the library to page elements, animating the appearance of certain elements as specified.