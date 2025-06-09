<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant - Search, add and request orders</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link
      rel="stylesheet"
      href="{{ asset('css/tabler-icons/webfont/tabler-icons.min.css') }}"
    />

    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.21.2/dist/sweetalert2.all.min.js
"></script>
    <link
      href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.21.2/dist/sweetalert2.min.css
"
      rel="stylesheet"
    />
    <script src="{{ asset('js/carousel.js') }}" defer></script>
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script defer>
      function showDetail() {
        if (!document.startViewTransition) {
          document
            .querySelector(".item-view")
            .classList.add("item-view--active");

          return;
        }
        document.startViewTransition(() => {
          document
            .querySelector(".item-view")
            .classList.add("item-view--active");
        });
      }

      // setTimeout(() => {
      //   showDetail();
      // }, 2000);
    </script>
  </head>
  <body class="layout layout--make-order">
    <nav class="navigation-bar">
      <button
        class="navigation-bar__button"
        type="button"
        aria-label="Close navigation bar"
        data-element="close-navigation-button"
      >
        <i class="button__icon ti ti-x"></i>
      </button>
      <div class="navigation-bar__header">
        <img
          src="{{ asset('img/600x400.png') }}"
          alt="Restaurant logo"
          class="navigation-bar__logo"
        />
      </div>
      <div class="navigation-bar__group">
        <strong class="navigation-bar__group-name">Menu</strong>
        <ul class="navigation-bar__items">
          <li
            class="navigation-bar__item navigation-bar__item--active"
            data-navigation-item="items"
          >
            <a href="#items" class="navigation-bar__anchor" aria-current="page">
              <i class="navigation-bar__item-icon ti ti-cube"></i>
              <span class="navigation-bar__item-name">Items</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="navigation-bar__group">
        <strong class="navigation-bar__group-name">Service</strong>
        <ul class="navigation-bar__items">
          <li class="navigation-bar__item" data-navigation-item="current-order">
            <a href="#current-order" class="navigation-bar__anchor">
              <i class="navigation-bar__item-icon ti ti-file-description"></i>
              <span class="navigation-bar__item-name">Current order</span>
            </a>
          </li>
          <li
            class="navigation-bar__item"
            data-navigation-item="previous-orders"
          >
            <a href="#previous-orders" class="navigation-bar__anchor">
              <i class="navigation-bar__item-icon ti ti-checklist"></i>
              <span class="navigation-bar__item-name">Previous orders</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="navigation-bar__user-data">
        <div class="tag tag--admin">ADMIN</div>
        <div class="navigation-bar__user-data-item" data-element="user--id">
          <strong class="navigation-bar__user-data-name">ID</strong>
          <span class="navigation-bar__user-data-value">?</span>
        </div>
        <div class="navigation-bar__user-data-item" data-element="user--name">
          <strong class="navigation-bar__user-data-name">Alias</strong>
          <span class="navigation-bar__user-data-value">?</span>
        </div>
        <div class="navigation-bar__user-data-item" data-element="user--table">
          <strong class="navigation-bar__user-data-name">Table</strong>
          <span class="navigation-bar__user-data-value">?</span>
        </div>
      </div>
    </nav>
    <header class="header">
      <button
        class="header__button"
        type="button"
        aria-label="Open navigation bar"
        title="Open navigation bar"
        data-element="open-navigation-button"
      >
        <i class="header__button-icon ti ti-menu-2"></i>
      </button>
      <div class="header__user-options">
        <button
          class="header__button"
          type="button"
          aria-label="See connected users"
          title="See connected users"
          data-element="see-connected-users-button"
        >
          <i class="header__button-icon ti ti-user-screen"></i>
        </button>
        <button
          class="header__button"
          type="button"
          aria-label="See table connection data"
          title="Table connection data"
          data-element="see-table-connection-data"
        >
          <i class="header__button-icon ti ti-qrcode"></i>
        </button>
        <button
          class="header__button"
          type="button"
          aria-label="See current order items"
          title="See current order items"
          data-element="see-current-order-button"
        >
          <i class="header__button-icon ti ti-file-description"></i>
        </button>
        <button
          class="header__button"
          type="button"
          aria-label="See previous orders"
          title="See previous orders"
          data-element="see-previous-orders-button"
        >
          <i class="header__button-icon ti ti-checklist"></i>
        </button>
        <button
          class="header__button"
          type="button"
          aria-label="See table receipt"
          title="Receipt"
          data-element="show-table-receipt-button"
        >
          <i class="header__button-icon ti ti-receipt-euro"></i>
        </button>
      </div>
    </header>
    <section class="page-section page-section--active" id="items">
      <div class="page-section__header">
        <div class="search-box">
          <div class="search-box__input-box">
            <label
              for="search-box--field"
              class="search-box__label"
              aria-label="Search product name"
            >
              <i class="search-box__icon ti ti-search"></i>
            </label>
            <input
              type="text"
              class="search-box__input-field"
              id="search-box--field"
            />
          </div>
          <div class="search-box__suggestions-results">
            <strong class="search-box__suggestions-title">Suggestions</strong>
            <div class="search-box__no-results">No suggestion found.</div>
            <ul class="search-box__suggestion-items">
              <!-- <li class="search-box__suggestion-item">
                <img
                  src="600x400.png"
                  alt="Item 1 picture"
                  class="search-box__item-image"
                />
                <strong class="search-box__item-name">#0 Item name</strong>
              </li>
              <li class="search-box__suggestion-item">
                <img
                  src="600x400.png"
                  alt="Item 1 picture"
                  class="search-box__item-image"
                />
                <strong class="search-box__item-name">#0 Item name</strong>
              </li> -->
            </ul>
          </div>
        </div>
      </div>
      <div class="carousel">
        <div class="carousel__container">
          <div class="carousel__figures">
            <figure class="carousel__figure" data-figure-element="intro">
              <img
                src="{{ asset('img/carrousel/eat-what-you-want.jpg') }}"
                alt="carousel figure 1"
                class="carousel__image"
              />
              <figcaption class="carousel__figure-data">
                <strong class="carousel__figure-heading featured-word">
                  Eat what you want!
                </strong>
                <p class="carousel__figure-description">
                  <span class="featured-word">Think and order</span> those items
                  you will eat. Remember you can do many orders.
                </p>
              </figcaption>
            </figure>
            <figure
              class="carousel__figure"
              data-figure-element="check-current-order"
            >
              <img
                src="{{ asset('img/carrousel/check-current-order.jpg') }}"
                alt="carousel figure 2"
                class="carousel__image"
              />
              <figcaption class="carousel__figure-data">
                <strong class="carousel__figure-heading featured-word">
                  <i class="featured-icon ti ti-file-description"></i>
                  Current order
                </strong>
                <p class="carousel__figure-description">
                  <span class="featured-word">See items</span> your guests added
                  to the order.
                </p>
              </figcaption>
            </figure>
            <figure
              class="carousel__figure"
              data-figure-element="check-previous-orders-status"
            >
              <img
                src="{{ asset('img/carrousel/check-previous-order.jpg') }}"
                alt="carousel figure 3"
                class="carousel__image"
              />
              <figcaption class="carousel__figure-data">
                <strong class="carousel__figure-heading featured-word">
                  <i class="featured-icon ti ti-checklist"></i>
                  Previous orders
                </strong>
                <p class="carousel__figure-description">
                  ¿An order got approved, denied? ¿What happened to my items?
                </p>
              </figcaption>
            </figure>
            <figure class="carousel__figure" data-figure-element="enjoy-food">
              <img
                src="{{ asset('img/carrousel/enjoy-food.jpg') }}"
                alt="carousel figure 4"
                class="carousel__image"
              />
              <figcaption class="carousel__figure-data">
                <strong class="carousel__figure-heading featured-word"
                  >Enjoy the food!</strong
                >
                <p class="carousel__figure-description">
                  Sit, relax and enjoy.
                </p>
              </figcaption>
            </figure>
          </div>
        </div>
        <div class="carousel__indicator">
          <button
            class="carousel__indicator-button carousel__indicator-button--active"
            type="button"
            aria-label="See figure 1"
            title="See figure 1"
            data-related-figure="intro"
          ></button>
          <button
            class="carousel__indicator-button"
            type="button"
            aria-label="See figure 2"
            title="See figure 2"
            data-related-figure="check-current-order"
          ></button>
          <button
            class="carousel__indicator-button"
            type="button"
            aria-label="See figure 3"
            title="See figure 3"
            data-related-figure="check-previous-orders-status"
          ></button>
          <button
            class="carousel__indicator-button"
            type="button"
            aria-label="See figure 4"
            title="See figure 4"
            data-related-figure="enjoy-food"
          ></button>
        </div>
      </div>
      <div class="menu">
        <div class="menu__header">
          <strong class="menu__title">Menu</strong>
          <div class="menu__header-options">
            <button
              class="menu__header-button"
              data-element="menu-filters-button"
              aria-label="Filter menu items"
              title="Filter"
            >
              <i class="menu__header-button-icon ti ti-filter"></i>
            </button>
          </div>
        </div>
        <nav class="menu__navigation">
          <button
            class="menu__navigation-button menu__navigation-button--active"
            data-related-category="frequent-order"
          >
            Frequent order
          </button>
          <button
            class="menu__navigation-button"
            data-related-category="Some category"
          >
            Some category
          </button>
        </nav>
        <div class="menu__results">
          <span class="menu__no-results">No items.</span>
          <div class="menu__items">
            <div class="menu-item">
              <div class="menu-item__tag menu-item__tag--supplement">
                Supplement +2,00€
              </div>
              <img
                src="{{ asset('img/600x400.png') }}"
                alt="Item image"
                class="menu-item__image"
              />
              <div class="menu-item__data">
                <div
                  class="menu-item__data-item menu-item__data-item--highlighted"
                  data-element="menu-item--name"
                >
                  <span class="menu-item__data-value">Some item</span>
                </div>
                <div
                  class="menu-item__data-item menu-item__data-item--subitem"
                  data-element="menu-item--quantity-type"
                >
                  <strong class="menu-item__data-name">Quantity type</strong>
                  <span class="menu-item__data-value">Complete</span>
                </div>
                <div
                  class="menu-item__data-item menu-item__data-item--subitem"
                  data-element="menu-item--quantity-type"
                >
                  <strong class="menu-item__data-name">Pieces per unit</strong>
                  <span class="menu-item__data-value">2</span>
                </div>
                <div
                  class="menu-item__data-item"
                  data-element="menu-item--allergens"
                >
                  <strong class="menu-item__data-name">Allergens</strong>
                  <span class="menu-item__data-value">
                    <i
                      class="menu-item__allergen-icon ti ti-egg"
                      aria-label="Egg"
                      title="Egg"
                    ></i>
                  </span>
                </div>
                <div class="menu-item__actions">
                  <button
                    class="button button--primary button--default button--rounded button--bigger"
                    type="button"
                    aria-label="Add item to current order"
                  >
                    <i class="button__icon ti ti-plus"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="page-section" id="current-order">
      <h2 class="page-section__heading">
        Current order
        <i class="refresh-current-order ti ti-refresh"></i>
      </h2>
      <form class="order-to-validate-form form" data-mode="show">
        <input type="hidden" name="order-id" value="3" />
        <div class="order-to-validate-form__data">
          <div
            class="order-to-validate-form__data-item order-to-validate-form__data-item--highlighted"
            data-element="order-id"
          >
            <strong class="order-to-validate-form__data-name">Order</strong
            ><span class="order-to-validate-form__data-value">3</span>
          </div>
        </div>
        <div class="order-to-validate-form__items">
          <table class="table">
            <tr class="table__row table__row--heading">
              <th class="table__cell table__cell--heading" id="order-3--id">
                ID
              </th>
              <th class="table__cell table__cell--heading" id="order-3--name">
                Name
              </th>
              <th
                class="table__cell table__cell--heading"
                id="order-3--quantity"
              >
                Quantity
              </th>
              <th
                class="table__cell table__cell--heading"
                id="order-3--supplement"
              >
                Supplement
              </th>
              <th
                class="table__cell table__cell--heading"
                data-edit-mode-only="true"
              ></th>
            </tr>
            <tbody class="table__body">
              <tr class="table__row">
                <td class="table__cell">1</td>
                <td class="table__cell">Some item</td>
                <td class="table__cell">
                  <div class="quantity-control">
                    <button
                      class="quantity-control__button"
                      type="button"
                      data-element="quantity-control-decrement-button"
                      aria-label="Decrement"
                    >
                      −</button
                    ><input
                      class="quantity-control__input"
                      type="number"
                      min="1"
                      max="99"
                      value="3"
                      aria-labelledby="order-3--quantity"
                      readonly="true"
                    /><button
                      class="quantity-control__button"
                      type="button"
                      data-element="quantity-control-increment-button"
                      aria-label="Increment"
                    >
                      +
                    </button>
                  </div>
                </td>
                <td class="table__cell table__cell--supplement">0,00</td>
                <td class="table__cell" data-edit-mode-only="true">
                  <div class="table__cell-options">
                    <button
                      class="table__button table__button--remove-item"
                      type="button"
                      aria-label="Remove item"
                      title="Remove item"
                    >
                      <i class="table__icon ti ti-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <fieldset class="order-to-validate-form__actions">
          <button
            class="button button--primary button--request-order"
            type="button"
            aria-label="Request order"
            data-element="order-to-validate-request-button"
          >
            Request
          </button>
        </fieldset>
      </form>
    </section>
    <section class="page-section" id="previous-orders">
      <h2 class="page-section__heading">
        Previous orders
        <i class="refresh-previous-orders ti ti-refresh"></i>
      </h2>
      <div class="page-section__orders">
        <div class="order">
          <div class="order__data">
            <div
              class="status status--in-queue status--no-circle status--with-background"
            >
              In queue
            </div>
            <div class="order__data-item order__data-item--highlighted">
              <strong class="order__data-name">Order</strong>
              <span class="order__data-value">0</span>
            </div>
            <div class="order__data-item">
              <strong class="order__data-name">Added at</strong>
              <span class="order__data-value">10/05/2025 10:00h</span>
            </div>
          </div>
          <ul class="order__items">
            <li class="order__item" data-item-status="in-queue">
              <strong class="order__item-name">0 Item name (x1)</strong>
              <div class="status status--in-queue">In queue</div>
            </li>
            <li class="order__item">
              <details class="order__item-details">
                <summary class="order__item-data">
                  <span class="order__item-name">1 Item name (x3)</span>
                  <div class="order__item-statuses">
                    <div
                      class="status status--in-queue"
                      aria-label="In queue Item name"
                    >
                      3
                    </div>
                    <div
                      class="status status--preparing"
                      aria-label="Preparing Item name"
                    >
                      0
                    </div>
                    <div
                      class="status status--completed"
                      aria-label="Completed Item name"
                    >
                      0
                    </div>
                  </div>
                </summary>
                <ul class="order__items order__items--subitems">
                  <li
                    class="order__item order__item--subitem"
                    data-item-status="in-queue"
                  >
                    <strong class="order__item-name">Item name</strong>
                    <div class="status status--in-queue">In queue</div>
                  </li>
                </ul>
              </details>
            </li>
          </ul>
        </div>

        <div class="order">
          <div class="order__data">
            <div
              class="status status--in-queue status--no-circle status--with-background"
            >
              In queue
            </div>
            <div class="order__data-item order__data-item--highlighted">
              <strong class="order__data-name">Order</strong>
              <span class="order__data-value">0</span>
            </div>
            <div class="order__data-item">
              <strong class="order__data-name">Added at</strong>
              <span class="order__data-value">10/05/2025 10:00h</span>
            </div>
          </div>
          <ul class="order__items">
            <li class="order__item" data-item-status="in-queue">
              <strong class="order__item-name">0 Item name (x1)</strong>
              <div class="status status--in-queue">In queue</div>
            </li>
            <li class="order__item">
              <details class="order__item-details">
                <summary class="order__item-data">
                  <span class="order__item-name">1 Item name (x3)</span>
                  <div class="order__item-statuses">
                    <div
                      class="status status--in-queue"
                      aria-label="In queue Item name"
                    >
                      3
                    </div>
                    <div
                      class="status status--preparing"
                      aria-label="Preparing Item name"
                    >
                      0
                    </div>
                    <div
                      class="status status--completed"
                      aria-label="Completed Item name"
                    >
                      0
                    </div>
                  </div>
                </summary>
                <ul class="order__items order__items--subitems">
                  <li
                    class="order__item order__item--subitem"
                    data-item-status="in-queue"
                  >
                    <strong class="order__item-name">Item name</strong>
                    <div class="status status--in-queue">In queue</div>
                  </li>
                </ul>
              </details>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <div class="item-view" data-item-id="0">
      <div class="item-view__header">
        <button
          class="item-view__header-button"
          type="button"
          aria-label="Return to menu"
          title="Return to menu"
        >
          <i class="item-view__header-button-icon ti ti-math-lower"></i>
        </button>
        <div class="item-view__header-options">
          <button
            class="item-view__header-button"
            type="button"
            aria-label="See current order"
            title="See current order"
          >
            <i class="item-view__header-button-icon ti ti-file-description"></i>
          </button>
        </div>
      </div>
      <img src="{{ asset('img/600x400.png') }}" alt="Item image" class="item-view__image" />
      <div class="item-view__data">
        <div
          class="item-view__data-item item-view__data-item--highlighted"
          data-item-element="name"
        >
          <span class="item-view__data-value">Some item</span>
        </div>
        <div class="item-view__data-item item-view__data-item--supplement">
          Supplement +2,00€
        </div>
        <div
          class="item-view__data-item item-view__data-item--category"
          data-item-element="category"
        >
          <strong class="item-view__data-name">Category</strong>
          <span class="item-view__data-value">Some category</span>
        </div>
        <div
          class="item-view__data-item item-view__data-item--description"
          data-item-element="description"
        >
          <strong class="item-view__data-name">Description</strong>
          <span class="item-view__data-value">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit.
            Laudantium, hic et. Quam ea dolore cumque expedita sit odio, ab
            ratione consectetur nemo recusandae nisi laborum nostrum quibusdam
            officiis voluptate delectus neque eligendi!
          </span>
        </div>
        <div class="item-view__data-item item-view__data-item--quantity-data">
          <strong class="item-view__data-name">Quantity data</strong>
          <span class="item-view__data-value">
            <ul class="item-view__quantity-data-items">
              <li class="item-view__quantity-data-item">
                <span class="item-view__quantity-data-value"
                  >Pieces per unit</span
                >
                <strong class="item-view__quantity-data-name">Type</strong>
              </li>
              <li class="item-view__quantity-data-item">
                <span class="item-view__quantity-data-value">0</span>
                <strong class="item-view__quantity-data-name">pcs/unit</strong>
              </li>
            </ul>
          </span>
        </div>
        <div class="item-view__data-item item-view__data-item--allergens">
          <strong class="item-view__data-name">Allergens</strong>
          <span class="item-view__data-value">
            <div class="item-view__allergens">
              <label class="allergen">
                <input
                  type="checkbox"
                  class="allergen__checkbox"
                  id="item-id-view-allergen--checkbox"
                />
                <i class="allergen__icon ti ti-egg"></i>
                <span class="allergen__name">Egg</span>
              </label>
            </div>
          </span>
        </div>
      </div>
      <div class="item-view__actions">
        <div class="quantity-control">
          <button
            class="quantity-control__button"
            type="button"
            data-element="quantity-control-decrement-button"
            aria-label="Decrement"
          >
            &minus;</button
          ><input
            class="quantity-control__input"
            type="number"
            min="1"
            max="99"
            value="3"
            aria-labelledby="order-3--quantity"
          /><button
            class="quantity-control__button"
            type="button"
            data-element="quantity-control-increment-button"
            aria-label="Increment"
          >
            &plus;
          </button>
        </div>
        <button
          class="button button--primary button--default button--add-to-order"
          type="button"
          aria-label="Add item to current order"
        >
          <i class="button__icon ti ti-cube-plus"></i>
          <span class="button__name">Add to order</span>
        </button>
      </div>
    </div>
    <div class="modal" role="dialog">
      <div class="modal__overlay" aria-hidden="true"></div>
      <div class="modal__container">
        <div class="modal__header">
          <strong class="modal__title">Manage connected users</strong>
          <div class="modal__header-options">
            <button
              class="modal__header-button"
              type="button"
              aria-label="Close this modal"
            >
              <i class="modal__header-button-icon ti ti-x"></i>
            </button>
          </div>
        </div>
        <div class="modal__content">
          <div class="modal__results">
            <h3 class="modal__results-title">Connected users</h3>
            <p class="modal__no-results">No user connected.</p>
            <ul class="modal__connected-users">
              <li class="connected-user">
                <div class="connected-user__data">
                  <div class="connected-user__name">Username</div>
                  <div class="connected-user__id">0000-0000-0000-0000</div>
                </div>
                <div class="tag tag--admin">ADMIN</div>
                <form
                  action="/restaurant-distribution/table-id/user-id"
                  class="connected-user__form"
                >
                  <fieldset class="connected-user__form-options">
                    <button
                      class="button button--primary button--disconnect"
                      type="submit"
                      aria-label="Disconnect username"
                      title="Disconnect username"
                    >
                      <i class="button__icon ti ti-user-minus"></i>
                    </button>
                  </fieldset>
                </form>
              </li>
              <li class="connected-user">
                <div class="connected-user__data">
                  <div class="connected-user__name">Username</div>
                  <div class="connected-user__id">0000-0000-0000-0000</div>
                </div>
                <form
                  action="/restaurant-distribution/table-id/user-id"
                  class="connected-user__form"
                >
                  <fieldset class="connected-user__form-options">
                    <button
                      class="button button--primary button--disconnect"
                      type="submit"
                      aria-label="Disconnect username"
                      title="Disconnect username"
                    >
                      <i class="button__icon ti ti-user-minus"></i>
                    </button>
                  </fieldset>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal"
      data-element="connected-users"
      data-table-id="0"
      role="dialog"
    >
      <div class="modal__container">
        <div class="modal__header">
          <strong class="modal__title">Table management</strong>
          <div class="modal__header-options">
            <button
              class="modal__header-button"
              data-element="close-modal-button"
              type="button"
              aria-label="Close modal"
              title="Close modal"
            >
              <i class="modal__header-button-icon ti ti-x"></i>
            </button>
          </div>
        </div>
        <div class="modal__content">
          <h2 class="modal__heading">Connected users</h2>
          <div class="modal__connected-users">
            <div class="connected-user">
              <i class="connected-user__icon ti ti-user-circle"></i>
              <div class="connected-user__data">
                <div class="connected-user__name">Some name</div>
                <div class="connected-user__id">0000-0000-0000</div>
              </div>
              <div class="connected-user__tag">
                <div class="tag tag--admin">ADMIN</div>
              </div>
              <div class="connected-user__options">
                <button
                  class="connected-user__button"
                  type="button"
                  aria-label="Disconnect user"
                >
                  <i class="connected-user__button-icon ti ti-user-minus"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal class="modal" role="dialog">
      <div class="modal__container">
        <div class="modal__header">
          <strong class="modal__title"></strong>
          <div class="modal__header-options">
            <button
              class="modal__header-button"
              type="button"
              data-element="close-modal-button"
              aria-label="Close modal"
            >
              <i class="modal__header-button-icon ti ti-x"></i>
            </button>
          </div>
        </div>
        <div class="modal__content">
          <h2 class="modal__heading">Quantity</h2>
          <div class="modal__quantity-control">
            <div class="quantity-control">
              <button
                class="quantity-control__button"
                type="button"
                data-element="quantity-control-decrement-button"
                aria-label="Decrement"
              >
                −</button
              ><input
                class="quantity-control__input"
                type="number"
                min="1"
                max="99"
                value="3"
                aria-labelledby="order-3--quantity"
              /><button
                class="quantity-control__button"
                type="button"
                data-element="quantity-control-increment-button"
                aria-label="Increment"
              >
                +
              </button>
            </div>
          </div>
          <div class="modal__actions">
            <button class="button button--primary button--accept">
              Accept
            </button>
            <button class="button button--primary button--cancel">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </modal>
    <div class="modal" role="dialog" data-element="items-filter-modal">
      <div class="modal__container">
        <div class="modal__header">
          <strong class="modal__title">Filter menu</strong>
          <div class="modal__header-options">
            <button
              class="modal__header-button"
              type="button"
              aria-label="Reset Filters"
              title="Reset filters"
              data-element="reset-filters-button"
            >
              <i class="modal__header-button-icon ti ti-filter-off"></i>
            </button>
            <button
              class="modal__header-button"
              type="button"
              aria-label="Close modal"
              title="Close modal"
              data-element="close-modal-button"
            >
              <i class="modal__header-button-icon ti ti-x"></i>
            </button>
          </div>
        </div>
        <div class="modal__content">
          <h2 class="modal__heading">Filters</h2>
          <div class="modal__filter-items">
            <div class="modal__filter-item">
              <strong class="modal__filter-name"
                >Exclude items with allergen</strong
              >
              <div class="modal__filter-value modal__filter-value--allergens">
                <label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    class="allergen__icon ti ti-ti ti-wheat"
                  ></i
                  ><span class="allergen__name">Gluten</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      xmlns="http://www.w3.org/2000/svg"
                      width="500"
                      height="500"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M364 179v-1c30.829-12.92 46.934-56.176 26.24-84-14.877-20-40.036-30.313-63.24-37-9.963-2.871-28.707-10.748-38.895-6.813-7.04 2.72-5.702 12.252.91 14.419C319.67 74.65 354.563 75.306 376.62 103c12.502 15.697 6.779 36.25-5.794 49.985C355.922 169.268 329.572 176.941 308 177c11.525-17.098 17.294-37.903 24.797-57 2.276-5.793 8.278-16.055 2.77-21.566-5.22-5.223-18.158-.804-24.567.145-23.275 3.445-46.956 5.651-70 10.424-6.44 1.334-22.266 2.864-24.581 10.052-6.643 20.622 8.457 50.14 20.48 65.945 3.818 5.02 9.3 12.2 15.101 14.958 9.712 4.617 26.646-5.283 37.09-5.007 32.094.849 63.284 4.554 94.91-4.103 13.967-3.823 29.217-10.092 38.32-21.849 32.618-42.13-2.787-97.955-39.32-121.996-9.635-6.34-20.214-11.507-31-15.578-3.807-1.437-8.848-3.952-12.956-2.491-7.054 2.508-5.73 11.486-.025 14.509 23.19 12.286 46.263 19.92 63.312 41.557 15.488 19.656 25.24 56.984 4.629 76.907C395.477 173.006 379.1 176.155 364 179m-142 30 12-3c-4.347-9.334-13.19-16.996-18.547-26-10.1-16.978-15.453-37.31-15.453-57-10.527 1.877-21.084 9.406-30 15.053-3.1 1.964-8.1 4.286-9.306 8.04-1.751 5.45 3.162 14.862 5.117 19.907 7.531 19.44 19.398 36.76 36.189 49.154 6.487 4.789 16.87 22.565 24.997 21.574 16.262-1.984-1.437-22.323-4.997-27.728m57-82.467c8.965-.614 9.94 13.31.996 14.18-9.155.891-10.304-13.542-.996-14.18M145 157c-8.734 8.735-29.153 26.534-29.397 40-.098 5.424 4.478 11.592 7.211 16 8.361 13.484 24.012 33.36 39.186 39.433 6.411 2.566 14.378-1.01 21 1.131 7.079 2.289 12.62 12.277 20.956 9.998 6.583-1.8 5.734-10.154 1.816-14.098C198.079 241.719 189.815 237 179 237l11-12c-14.685-11.189-25.565-26.624-33.753-43-3.804-7.607-5.713-18.722-11.247-25m-39 59c-3.087 9.49-8.91 22.847-7.066 33 1.055 5.805 6.448 11.472 9.954 16 10.755 13.892 24.716 26.428 40.112 35l1-5c4.117-.532 10.916-3.542 14.816-1.799 5.89 2.634 8.307 14.976 17.075 10.466 10.63-5.468-2.83-23.118-8.93-26.91-4.903-3.048-12.73.228-17.961 1.243l3-10c-13.595-9.173-25.993-19.507-36.7-32-5.4-6.3-9.227-14.434-15.3-20m-9 60c.583 28.238 9.602 57.33 20.861 83 4.841 11.038 12.145 21.741 16.17 33 4.846 13.557 3.757 29.857 7.83 44 3.735 12.973 9.727 25.734 17.142 37 2.443 3.711 5.139 9.439 10.012 10.242 5.923.977 8.995-4.07 8.93-9.242-.146-11.756-2.793-24.452-4.945-36 7.452 1.004 14.67 3.667 22 5.349 6.733 1.545 17.139 5.799 23.985 4.178 6.183-1.464 7.256-8.895 3.581-13.343-4.932-5.97-14.038-10.32-20.566-14.376-11.47-7.125-22.765-14.651-34-22.141-5.263-3.509-13.717-7.19-17.012-12.76-6.744-11.402-5.18-36.93-4.86-49.907.133-5.361 2.128-11.465.554-16.787-1.448-4.896-11.65-8.454-15.682-11.238-12.836-8.864-21.847-21.681-34-30.975Z"
                      ></path></svg></i
                  ><span class="allergen__name">Seafood</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    class="allergen__icon ti ti-ti ti-egg"
                  ></i
                  ><span class="allergen__name">Egg</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    class="allergen__icon ti ti-ti ti-fish"
                  ></i
                  ><span class="allergen__name">Fish</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    class="allergen__icon ti ti-ti ti-brand-peanut"
                  ></i
                  ><span class="allergen__name">Peanut</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      xmlns="http://www.w3.org/2000/svg"
                      width="500"
                      height="500"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M392 92c-8.122 6.446-19.87 18.915-30 21.448-5.697 1.424-13.909-1.517-20-1.444-11.83.14-23.562 4.957-33 11.92-13.097 9.664-22.5 24.355-26.522 40.076-2.65 10.357-.5 22.651-8.779 30.671-8.208 7.951-19.429 5.676-29.699 7.779-11 2.252-20.557 8.075-28.985 15.304-11.414 9.788-18.85 23.713-22.127 38.246-2 8.874-.357 18.418-6.572 25.907-7.912 9.534-20.49 7.268-31.316 9.988-14.333 3.6-25.958 11.283-35.907 22.105-10.021 10.901-16.06 26.28-17.003 41-.383 5.992 2.15 12.08 1.06 18-2.434 13.23-10.6 24.127-16.15 36 14.835 0 29.396-2.45 44-2.736 8.309-.163 16.42 3.918 25 3.721 23.04-.527 44.886-14.436 56.547-33.985 4.957-8.31 8.982-18.232 9.414-28 .282-6.386-2.824-17.75 1.473-22.855 5.283-6.276 18.216-1.603 25.566-2.315 13.291-1.286 25.936-7.503 36-16.13 10.534-9.03 18.76-22.193 22.101-35.7 2.384-9.639.638-20.247 8.004-27.957 7.435-7.783 15.363-5.974 24.895-7.658 9.83-1.737 18.873-5.285 27-11.131 30.592-22.006 34.27-63.881 31.075-98.254-.933-10.03-.84-25.274-6.075-34m-53 37.29c26.338-3.432 43.264 20.382 40.83 44.71-2.164 21.628-19.962 41.863-41.83 44.71-27.302 3.556-43.293-21.092-40.83-45.71 2.194-21.927 19.941-40.86 41.83-43.71m0 16.228c-13.825 2.927-25.27 16.297-25.96 30.482-.702 14.421 7.005 29.649 23.96 26.532 15.498-2.85 26.464-18.244 26.957-33.532.446-13.866-10.29-26.588-24.957-23.482M249 218.3c24.685-3.558 46.29 15.174 43.83 40.7-2.197 22.8-19.49 43.67-42.83 46.71-26.54 3.458-44.549-18.298-41.826-43.71 2.23-20.82 19.782-40.666 40.826-43.7m1 16.23c-13.209 3.03-24.369 16.058-25.826 29.47-1.715 15.775 9.329 28.907 25.826 25.33 14.852-3.22 25.696-17.442 26.815-32.33 1.148-15.275-12.182-25.829-26.815-22.47m-83 71.845c21.94-1.122 40.706 17.474 38.826 39.625-1.98 23.343-21.6 45.89-45.826 46.96-29.794 1.317-48.374-24.779-38.3-52.96 6.721-18.803 25.399-32.608 45.3-33.625m-4 17.09c-13.262 2.39-24.31 13.42-27.32 26.535-3.942 17.179 9.46 29.628 26.32 26.671 13.008-2.28 23.991-13.986 26.71-26.671 3.667-17.112-8.618-29.617-25.71-26.535Z"
                      ></path></svg></i
                  ><span class="allergen__name">Soybeans</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    class="allergen__icon ti ti-ti ti-milk"
                  ></i
                  ><span class="allergen__name">Milk</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      xmlns="http://www.w3.org/2000/svg"
                      width="500"
                      height="500"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M265 126.424c-15.864 2.083-30.767 1.895-46 8.029-28.599 11.515-48.152 37.983-68.116 60.26-16.439 18.345-32.901 34.485-38.459 59.287C98.184 317.552 140.993 383.675 206 395.424c8.709 1.574 17.035 4.39 26 3.29 14.848-1.824 30.284-3.344 44-9.614 25.946-11.862 43.134-34.75 62.09-55.1 17.63-18.928 34.726-36.585 42.34-62 9.974-33.296-3.686-69.838-11.195-102-1.902-8.146-1.846-28.036-8.383-33.347-6.39-5.193-20.024-3.206-27.852-3.743-22.225-1.522-45.668-9.418-68-6.486m-21.005 15.895c3.774-.381 6.858 1.6 4.958 5.686-4.459 9.587-16.553 14.314-19.559 24.995-2.563 9.107 6.034 21.125.653 29.816-4.905 7.922-18.654 11.576-26.046 16.97-4.192 3.058-9.75 9.269-2.892 13.031 4.598 2.522 9.08-1.088 12.891-3.368 9.658-5.775 24.39-10.856 31.486-19.735 6.767-8.468-1.798-20.589-1.335-29.714.569-11.187 20.725-30.724 29.849-35.91 10.958-6.23 35.852-.913 48 .78 3.818.532 12.929.696 14.263 5.355 1.049 3.66-3.105 7.449-5.302 9.775-6.535 6.918-12.845 14.072-19.572 20.804-27.528 27.548-52.405 58.017-79.35 86.196-7.773 8.129-16.678 16.833-23.159 26-2.718 3.845-5.322 8.947.179 11.806 10.007 5.202 23.424-17.995 28.98-23.806 27.478-28.737 54.959-57.996 81.041-88 7.092-8.158 14.474-16.143 21.895-23.996 2.123-2.247 5.826-7.638 9.596-6.292 3.419 1.221 5.157 12.04 5.926 15.288 3.694 15.614 7.502 31.163 10.253 47 3.151 18.144 3.357 38.92-4.64 56-10.036 21.438-29.416 37.499-44.825 55-19.506 22.156-43.095 47.348-75.28 47.606-10.872.087-2.543-12.91-.53-17.606 3.373-7.868 5.084-16.905 10.39-23.826 4.089-5.333 11.623-8.388 14.79-14.217 2.106-3.876-.22-8.805-4.694-9.58-5.423-.94-11.282 5.899-14.961 9.051-17 14.566-14.416 36.577-27.79 52.424-4.855 5.754-12.304 1.49-18.21.046-15.717-3.842-31.007-11.963-42.96-23.07-30.827-28.644-44.417-78.136-25.07-116.828 9.823-19.648 27.163-35.059 41.941-51 19.15-20.657 39.16-43.655 69.084-46.68m82.384 86.708c-5.834 3.626-13.394 19.256-14.147 25.968-.611 5.447 4.377 10.379 9.75 7.67 6.342-3.195 13.719-18.81 14.535-25.666.679-5.699-4.146-11.697-10.138-7.972M172 276.468c-5.255.864-12.715 2.78-16.258 7.086-4.784 5.817 1.174 11.08 7.258 10.052 4.904-.83 14.019-3.43 17.397-7.244 5.763-6.51-2.682-10.834-8.397-9.894m131.059 16.564c-10.418 5.567 2.717 16.065 10.623 10.789 8.161-5.447-4.146-14.251-10.623-10.79m-121.04 30.001c-7.556 3.803-4.53 16.829 3.962 12.897 7.834-3.628 4.699-17.255-3.962-12.897z"
                      ></path></svg></i
                  ><span class="allergen__name">Nuts</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      width="500"
                      height="500"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M411 226c4.904-9.607 16.192-18.543 16.877-30 .882-14.765-30.514-22.764-41.877-23 2.744-10.052 14.782-33.984 3.867-42.297-5.17-3.937-19.8-.771-22.67-6.02-4.935-9.026.68-22.879-4.65-32.639C354.941 78.115 325.79 93.924 316 98c-9.205-24.286-25.72-14.985-40-1-2.122-5.097-4.736-12.849-10.093-15.333-5.419-2.512-11.116.66-15.907 3.09-12.344 6.26-22.999 15.718-30.644 27.243-6.09 9.179-9.748 20.906-9.316 32 .25 6.4 4.502 15.365.667 21-11.319 16.63-27.004 31.128-39.496 47-26.19 33.275-50.298 68.18-71.211 105-12.502 22.013-25.296 48.23-12.727 73 3.615 7.124 9.318 12.136 14.553 18 4.63 5.185 8.219 10.594 14.174 14.452 15.187 9.84 24.259 3.763 40 3.39 15.667-.37 27.824 2.559 41-9.027 12.272-10.792 20.364-27.51 29.72-40.815 18.415-26.184 38.266-51.742 59.15-76 9.934-11.539 20.591-25.916 33.13-34.708 5.807-4.071 21.438 8.932 28 11.269 15.998 5.698 33.261 3.28 48-4.74 17.402-9.468 44.14-31.223 16-45.821M258 104c3.029 7.85 10.107 23.39 4.972 31.621-3.452 5.535-12.268 9.517-16.933 14.38-4.024 4.196-6.914 10.197-12.039 12.999-5.366-23.193-3.606-50.188 24-59m40 1c2.073 3.551 3.964 7.21 5.572 11 1.294 3.05 3.621 7.502 2.651 10.906-2.673 9.378-29.008 6.114-22.156-8.906 1.248-2.734 3.84-4.92 5.934-6.995 2.517-2.494 4.803-4.515 7.999-6.005m48 3c.925 4.98 3.487 17.17-1.434 20.606-5.877 4.103-20.349-4.704-18.734-11.447 1.332-5.563 15.436-8.064 20.168-9.159m-25 36c2.231 6.857 7.894 17.702 5.382 25-2.451 7.12-10.954 12.14-14.6 19-3.796 7.14-4.577 16.594-11.782 21-12.421-21.848-7.659-58.266 21-65m52 3-1 7-26 6c-4.304-16.643 15.241-13.928 27-13m-91 4c-4.256 11.696-8.992 21.167-9 34l-24-5c5.107-13.95 17.962-26.965 33-29m82 24c2.34 7.915 2.431 25.033-3.702 31.486-3.21 3.377-10.087 3.585-14.298 5.387-7.969 3.41-14.684 8.612-22 13.127 0-27.567 12.555-43.708 40-50m-141 9c4.713 9.008 14.59 11.516 23 16v1c-15.506 11.815-28.876 27.742-42.089 42-39.704 42.844-69.641 88.848-96.911 140-15.152-15.124 2.156-41.532 9.745-56 19.629-37.425 45.802-71.704 71.605-105 9.127-11.778 20.958-31.615 34.65-38m182 15c-6.14 12.328-11.569 15.815-24 10l3-16 21 6m-134 6.593c7.532-2.467 15.358 15 11.577 20.122-4.055 5.493-10.656 9.618-15.577 14.324-11.223 10.732-22.082 21.916-32.996 32.961-24.066 24.356-46.352 52.643-64.004 82-7.784 12.946-15.025 26.173-21.138 40-1.906 4.311-3.483 13.534-8.917 14.593-6.475 1.261-18.145-4.024-16.987-11.594 2.441-15.964 13.12-32.388 21.243-45.999 24.228-40.599 55.42-78.62 88.799-112 10.145-10.145 24.003-29.822 38-34.407M401 242v1c-14.32 13.695-31.848 21.2-51 13.395-7.654-3.119-13.807-6.77-15-15.395 24.134-15.897 42.216-17.281 66 1m-96-9c.092 4.45 2.89 10.858 1.597 15-1.336 4.284-6.53 7.933-9.597 11-7.45 7.45-14.692 15.018-21.575 23-25.095 29.104-48.284 59.71-70.566 91-10.051 14.114-19.024 37.438-39.859 34 17.235-50.615 58.929-97.869 96-135 12.378-12.398 28.073-31.574 44-39z"
                      ></path></svg></i
                  ><span class="allergen__name">Celery</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      width="500"
                      height="500"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M233.004 52.742c-6.868 2.661-7.166 10.063-8.404 16.258-1.992 9.974-3.976 19.973-5.681 30-.66 3.88-.804 10.439-3.657 13.411-3.496 3.641-12.54 3.902-17.262 5.31-11.989 3.573-25.751 9.074-32.52 20.279-6.45 10.676-4.811 31.861-3.295 44 .551 4.41 5.253 9.701 3.883 14-2.437 7.645-11.35 12.013-13.688 20-8.474 28.944-8.727 63.075-12.662 93-2.974 22.62-9.626 46.464-5.118 69 2.396 11.974 2.644 30.605 9.254 40.96 8.575 13.432 34.772 17.215 49.146 19.626 46.892 7.867 104.205 9.11 149-9.039 22.515-9.122 21.575-33.416 25.8-54.547 4.133-20.669-2.791-44.26-5.518-65-2.893-21.998-5.612-44.053-8.86-66-1.334-9.006-1.292-19.333-4.07-28-2.497-7.79-11.541-12.413-13.732-20-1.2-4.154 3.346-9.76 4.054-14 1.908-11.42 2.818-31.452-2.217-42-6.088-12.754-21.812-18.512-34.457-22.28-4.737-1.41-12.89-1.553-16.436-5.234-3.043-3.16-3.1-9.388-3.814-13.486-1.745-10.027-3.784-20.014-5.75-30-1.102-5.606-1.28-12.695-7.044-15.682C264.276 50.374 255.218 52 249 52c-4.914 0-11.34-1.061-15.996.742M258 72l12 64c-13.068 5.032-24.957 5.024-38 0l12-64h14m-46 62c-.765 34.504 77.977 34.504 78 0 7.046 2 29.364 6.128 29.364 15.99 0 9.898-24.223 14.503-31.364 16.122-24.315 5.513-52.788 5.43-77-.587-6.603-1.641-29.959-6.8-28.824-16.435 1.096-9.304 22.761-13.1 29.824-15.09m-11 58c-7.98-3.096-18.258-6.163-19-16 8.946 2.442 22.465 4.249 19 16m119-16c-.742 9.837-11.02 12.904-19 16-3.412-11.571 9.99-13.865 19-16m-79 23c-10.423-1.935-19.99 1.208-20-12 11.337.094 19.999-.917 20 12m40-12c-.01 13.208-9.577 10.065-20 12 .001-12.917 8.663-11.906 20-12m37 19c3.875 5.142 9.446 10.07 12.066 16 2.458 5.564 2.231 13.02 3.064 19l5.74 42c3.099 22.294 6.567 44.634 9.08 67 .782 6.962 4.096 18.23-.888 24.351-7.189 8.827-30.456 11.568-41.062 13.998-37.285 8.542-76.794 7.444-114-.773-9.9-2.187-30.335-5.128-37.143-13.214-7.172-8.52-.191-28.539.988-38.362 3.845-32.034 8.283-64.065 12.884-96 1.55-10.753 3.122-28.003 15.44-32.76 3.834-1.48 11.006 2.811 14.831 3.9 12.201 3.474 24.447 5.093 37 6.575 28.523 3.365 55.086-4.021 82-11.715m-114 71c-7.711 0-22.455-2.829-28.606 2.653C170.931 283.63 172 290.646 172 296v39c0 5.267-1.157 12.33 2.653 16.606C178.963 356.443 187.215 355 193 355h103c8.192 0 18 1.468 25.996-.394 6.814-1.587 7.972-7.529 8.003-13.606.068-13 .001-26 .001-39 0-5.783 1.319-13.539-1.01-18.957-5.035-11.72-20.465-2.08-28.765-7.07-3.267-1.965-4.54-6.918-6.588-9.972-3.259-4.862-7.652-8.518-12.637-11.536-22.823-13.82-71.403-8.865-77 22.535m39-9.7c11.39-1.641 27.103-.488 34.348 9.715 3.871 5.452 2.642 13.252 8.696 17.243 5.976 3.939 19.666-2.036 23.928 3.345 4.237 5.35 1.074 23.652 1.027 30.397-.02 2.953.312 6.655-3.147 7.682-7.738 2.297-18.787.318-26.852.318h-60c-6.41 0-23.29 3.017-28.397-1.028-4.726-3.743-1.615-24.18-1.603-29.972.006-2.704-.622-6.95 2.318-8.397 7.164-3.525 16.774 2.524 23.573-3.037 4.568-3.735 3.892-9.73 6.526-14.566 3.981-7.307 11.674-10.56 19.583-11.7M343 398c-2.299 17.802-23.929 19.43-39 21.92-35.888 5.93-74.17 5.354-110-.673-14.483-2.436-32.879-4.55-35-21.247 38.23 9.055 73.105 17.642 113 14.91 24.709-1.692 47.183-9.269 71-14.91z"
                      ></path></svg></i
                  ><span class="allergen__name">Mustard</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      width="500"
                      height="500"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M197 106.468c-25.967 4.13-58.77 17.537-70.51 42.532-11.85 25.227 3.536 61.17 35.51 56.557 32.842-4.739 41.172-36.623 43.83-64.557.738-7.754 1.993-36.253-8.83-34.532M402 201c0-24.25-3.297-53.348-18.899-72.96-14.852-18.67-43.645-26.15-61.927-7.866-18.399 18.398-10.225 46.458 7.826 61.5C347.803 197.344 378.333 201 402 201m-20-21c-8.163-.068-16.274-1.76-24-4.333-5.752-1.916-11.27-4.088-16-7.996-6.22-5.137-12.16-12.218-12.53-20.671-.939-21.455 23.504-21.437 35.49-10.7 5.032 4.509 8.257 10.455 10.615 16.7 3.292 8.722 4.708 17.885 6.425 27m-196-51c5.358 18.125-4.638 63.223-31 57.609-29.19-6.217-7.618-39.374 7-47.736 7.55-4.32 15.76-7.192 24-9.873m64 46c-.143 17.295-3.091 33.61-.572 51 1.46 10.07 4.188 19.495 9.932 28 7.24 10.72 18.484 19.414 31.64 20.826 29.27 3.143 47.385-25.722 38.134-51.826-2.542-7.174-6.827-13.599-12.149-18.996-7.792-7.903-16.989-12.806-26.985-17.31-12.195-5.493-26.587-10.598-40-11.694m17 24c7.899 1.167 16.078 4.49 23 8.428 5.497 3.128 11.3 6.557 15.24 11.611 10.907 14 9.228 42.811-15.24 36.403-12.49-3.271-19.701-17.746-21.56-29.442-1.427-8.97-1.44-17.944-1.44-27m-23 143c.143-17.275 3.066-33.638.572-51-1.421-9.894-4.057-19.672-9.793-28-6.47-9.396-16.358-18.046-27.779-20.482-31.261-6.67-52.383 24.623-41.768 52.482 2.853 7.486 7.957 14.455 13.772 19.91 7.423 6.964 16.606 12.1 25.996 15.89 12.215 4.929 25.776 10.148 39 11.2m-17-24c-7.86-1.16-14.971-4.708-22-8.248-5.393-2.715-10.327-5.783-14.535-10.18-6.367-6.652-11.764-17.16-8.812-26.572 6.278-20.016 29.39-11.816 37.647 1 3.391 5.263 5.133 10.86 6.11 17 1.435 9.028 1.59 17.883 1.59 27m64 90c13.899-2.869 28.132-6.707 41-12.78 11.06-5.222 21.868-11.354 29.47-21.22 8.682-11.266 13.881-28.107 8.982-42-9.074-25.733-40.404-31.374-60.413-14.985-5.58 4.57-10.499 10.547-13.766 16.985-5.15 10.148-6.233 20.917-7.558 32-1.59 13.296-.826 28.94 2.285 42M92 312c0 24.263 2.994 53.308 18.669 72.996 14.48 18.19 42.89 26.012 61.16 8.703 20.143-19.083 10.894-48.822-8.829-64.018C144.237 315.223 114.943 312 92 312m216 72c-5.35-18.098 4.125-61.897 30-57.667 30.029 4.908 8.838 39.306-6 47.794-7.55 4.32-15.76 7.192-24 9.873m-196-51c8.128.067 16.327 1.692 24 4.344 6.13 2.119 12.072 4.509 17 8.841 11.87 10.44 18.146 36.715-5 38.59-14.12 1.144-25.18-13.133-29.575-24.775-3.292-8.722-4.708-17.885-6.425-27z"
                      ></path></svg></i
                  ><span class="allergen__name">Sesame</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      width="500"
                      height="500"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M189.483 126.028C183.505 129.852 186 142.954 186 149c0 7.785-2.91 23.036 1.318 29.772 4.078 6.497 22.916 3.242 29.682 3.228 2.838-.006 6.351.374 8.681-1.603 3.748-3.18 1.639-8.912-2.725-10.08-4.985-1.332-25.21 3.14-22.718-7.274 2.657-11.109 22.357 1.22 24.08-9.147 2.47-14.861-23.833-1.218-23.833-11.526 0-10.482 22.27-1.554 26.335-7.687 2.439-3.68.128-8.385-3.914-9.38-6.273-1.543-27.931-2.788-33.423.725m78.836.004c-8.179 5.354 11.377 20.873 11.377 26.968 0 8.158-11.418 14.33-13.783 21.996-2.355 7.63 7.271 6.824 11.072 3.726 3.304-2.694 7.393-12.3 12.09-12.041 7.878.432 11.438 20.216 21.602 13.291 7.056-4.806-11.466-20.877-11.864-26.972-.55-8.397 11.432-13.758 12.425-21.957.82-6.764-7.755-5.53-11.053-2.648-2.94 2.57-6.832 12.602-11.52 11.823-6.682-1.111-10.566-20.589-20.346-14.186m-28.26 27.71c-3.996 1.672-5.45 7.353-1.741 10.169 3.735 2.835 12.43 3.09 16.623 1.231 3.956-1.754 5.852-8.22 1.741-10.963-3.43-2.289-12.921-1.986-16.623-.437m-49.015 47.125c-6.67 1.11-4.003 8.73-5.647 13.13-1.275 3.409-4.451 5.575-7.397 7.454-12.039 7.677-24.815 14.344-37 21.79-3.847 2.35-9.266 3.831-12.351 7.177C123.954 255.511 125 263.662 125 270v42c0 7.595-.912 14.991 5.185 20.66 14.612 13.586 37.059 17.889 51.756 31.553 4.663 4.335 2.58 19.845 12.044 17.09 8.178-2.382 3.943-12.116 8.333-17.09 8.556-9.696 26.304-16.885 37.682-22.867 3.92-2.062 8.252-6.457 13-5.6 5.549 1.002 10.248 5.816 15 8.533 10.54 6.026 25.095 11.433 33.772 19.996 4.691 4.63.916 19.563 11.184 17.247 7.587-1.71 4.256-15.563 12.048-20.008 12.06-6.88 24.192-13.948 35.996-21.286 4.966-3.087 11.623-5.358 14.99-10.402 3.258-4.878 2.01-12.254 2.01-17.826v-42c0-6.174 1.402-13.925-3.228-18.79-13.293-13.97-35.565-19.149-50.757-30.82-6.288-4.83-3.49-15.048-9.163-18.361-10.586-6.183-8.99 11.68-13 15.762-9.217 9.38-25.421 15.988-36.852 22.49-3.91 2.224-9.272 6.619-14 6.254-4.934-.38-9.85-4.681-14-7.047-10.31-5.878-26.614-12.24-34.682-20.867-4.407-4.712-.211-19.596-11.274-17.754M189 231.56c8.345-2.554 16.23 6.39 23 9.845 8.448 4.312 25.542 11.048 30.99 18.807C246.03 264.54 245 271.01 245 276c0 12.801 3.268 30.758-.514 42.985-1.728 5.585-7.965 7.553-12.486 10.325-11.41 6.998-24.943 18.545-38 21.948-7.406 1.93-20.92-9.189-27-13.077-7.688-4.918-20.83-8.876-26.258-16.39C137.774 317.68 139 310.784 139 306c0-12.76-2.953-29.699.434-42 1.506-5.47 7.186-7.699 11.566-10.498 11.035-7.055 25.55-18.13 38-21.941m120-.127c7.812-1.7 16.512 6.84 23 10.22 8.653 4.508 24.457 10.589 30.258 18.559C365.095 264.112 364 270.458 364 275c0 12.418 4.298 34.452-.742 45.79-2.032 4.57-8.26 6.475-12.258 8.803-11.277 6.568-25.201 19.021-38 21.854-8.545 1.891-24.78-12.261-32-16.527-6.382-3.771-15.98-6.858-20.397-13.094C257.847 317.934 259 311.518 259 307v-31c0-4.27-.988-10.071 1.028-13.985 5.39-10.465 25.277-16.806 34.972-22.71 4.303-2.62 9.003-6.783 14-7.87z"
                      ></path></svg></i
                  ><span class="allergen__name">Sulfite</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      width="500"
                      height="500"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M247 86.424c-17.739 2.33-35.924 4.333-50 16.76-27.487 24.27-33.501 88.236-5.96 114.723 21.956 21.116 65.055 18.19 92.96 14.808 13.877-1.682 28.979-6.244 38.826-16.755 22.121-23.612 18.935-76.608 1.4-101.96C308.08 90.657 274.06 82.87 247 86.424m-5 20.861c21.466-2.567 52.675-1.17 65.895 18.715 17.185 25.85 15.735 81.16-21.895 85.9-9.38 1.181-17.956-9.534-28-10.596-11.367-1.202-17.317 7.018-27 10.132-8.162 2.625-20.217-3-25.96-8.53C195.551 193.77 195 180.336 195 168c0-32.932 11.85-56.51 47-60.715M140 238.44c-14.065 2.214-26.988 10.766-37 20.576C87.596 274.11 72.18 295.415 72.18 318c-.003 43.867 52.244 94.578 96.821 87.561 34.694-5.461 77.657-46.004 70.192-83.561-4.416-22.217-21.82-38.628-37.192-54-16.391-16.391-37.124-33.476-62-29.56m218 0c-29.008 4.53-55.245 33.014-71.844 55.56-6.857 9.313-13.2 20.196-14.066 32-3.058 41.723 48.002 85.95 88.91 79.561 36.274-5.666 79.422-48.25 78.545-86.561-.855-37.335-41.052-86.885-81.545-80.56m-216 19.889c9.514-1.657 26.021 2.431 30.776 11.845 4.39 8.688 2.668 16.917 10.317 24.783 9.545 9.814 24.11 6.625 31.2 18.043 18.86 30.376-19.396 67.184-48.293 72.384-24.908 4.483-46.995-17.382-60.764-35.384-5.728-7.49-11.362-16.339-12.143-26-1.593-19.734 9.481-35.572 22.908-49 7.063-7.062 15.775-14.891 25.999-16.671m218-.003c25.59-4.274 57.162 31.85 58.91 55.674 2.262 30.841-32.022 67.431-61.91 71.7-29.958 4.278-76.428-36.49-62.099-67.7 7.813-17.017 25.602-11.817 36.57-26 5.307-6.865 4.488-14.574 8.043-21.826 3.156-6.438 13.803-10.732 20.486-11.848z"
                      ></path></svg></i
                  ><span class="allergen__name">Lupins</span></label
                ><label class="allergen"
                  ><input type="checkbox" class="allergen__checkbox" /><i
                    ><svg
                      class="allergen__icon"
                      width="500"
                      height="500"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 500 500"
                    >
                      <path
                        d="M201 123c-8.075-3.115-16.23-6.573-25-6.96-45.753-2.022-68 35.424-68 76.96-38.297 5.656-49.923 49.856-40.279 82C79.65 314.757 122.3 343.85 154 367.627c8.873 6.654 20.547 12.24 28 20.373-8.517 0-22.254-2.606-29.98 1.318-6.67 3.388-7.178 13.564.024 16.673C163.87 411.096 185.16 407 198 407h144c5.121 0 12.199 1.215 16.811-1.457 6.338-3.672 5.345-13.011-.855-16.225C350.319 385.36 336.45 388 328 388c9.918-11.657 27.777-20.048 40-29.576 26.957-21.011 60.996-46.056 72.91-79.424 11.614-32.526.999-80.106-38.91-86 0-41.446-22.41-78.975-68-76.96-8.841.39-16.88 3.81-25 6.96-20.53-43.156-87.52-43.102-108 0m78 201c-17.7-3.653-30.3-3.653-48 0-13.765-31.053-18.882-69.538-23.282-103-2.572-19.56-6.115-40.317-2.797-60 4.7-27.885 24.496-54.154 55.079-51.91 25.524 1.873 41.259 29.238 45.08 51.91 3.31 19.64-.232 40.495-2.95 60-4.669 33.508-9.34 71.85-23.13 103m-87-185c-1.535 10.435-5.493 20.318-5.96 31-2.438 55.653 16.627 109.69 28.96 163-7.219 3.737-10.414-1.454-14.79-7-8.52-10.8-16.84-21.77-24.786-33-21.685-30.651-47.047-64.533-50.25-103-2.146-25.77 15.134-53.17 41.826-55.83 8.767-.873 16.82 2.168 25 4.83m103 194c12.225-52.84 31.375-106.863 28.96-162-.483-11.047-4.373-21.214-5.96-32 8.18-2.662 16.233-5.703 25-4.83 27.339 2.724 43.12 29.96 41.79 55.83-1.948 37.941-29.055 73.093-50.214 103-7.728 10.922-15.82 21.554-24.176 32-4.537 5.671-7.752 11.96-15.4 8M111 212c4.167 20.137 16.156 38.79 26.95 56 17.504 27.909 36.202 57.127 59.05 81v1l-10 17c-11.543-3.678-22.536-14.05-32-21.424-24.775-19.303-57.671-42.27-69.186-72.576-7.967-20.969-3.843-59.67 25.186-61m212 155c-2.473-4.237-8.645-12.142-8.684-17-.033-4.028 4.905-8.127 7.26-11 6.941-8.47 13.5-17.228 20.05-26 21.544-28.851 49.937-65.066 57.374-101 28.885 1.339 33.106 40.155 25.186 61-11.519 30.315-44.447 53.15-69.186 72.424-9.532 7.427-20.35 17.864-32 21.576m-12 21H199c4.186-14.86 9.73-27.552 22-37.671 22.715-18.733 56.94-13.486 75.826 7.671 7.742 8.673 11.094 19.067 14.174 30z"
                      ></path></svg></i
                  ><span class="allergen__name">Molluscs</span></label
                >
              </div>
            </div>
            <div class="modal__filter-item">
              <strong class="modal__filter-name"
                >Include items with supplement</strong
              >
              <div class="modal__filter-value">
                <label class="switch">
                  <input
                    class="switch__checkbox"
                    checked="true"
                    type="checkbox"
                  />
                  <div class="switch__slider">
                    <div class="switch__circle">
                      <svg
                        class="switch__cross"
                        xml:space="preserve"
                        style="enable-background: new 0 0 512 512"
                        viewBox="0 0 365.696 365.696"
                        y="0"
                        x="0"
                        height="6"
                        width="6"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <g>
                          <path
                            data-original="#000000"
                            fill="currentColor"
                            d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0"
                          ></path>
                        </g>
                      </svg>
                      <svg
                        class="switch__checkmark"
                        xml:space="preserve"
                        style="enable-background: new 0 0 512 512"
                        viewBox="0 0 24 24"
                        y="0"
                        x="0"
                        height="10"
                        width="10"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <g>
                          <path
                            class=""
                            data-original="#000000"
                            fill="currentColor"
                            d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"
                          ></path>
                        </g>
                      </svg>
                    </div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="modal__actions">
            <button
              class="button button--primary button--apply-filters"
              type="button"
              aria-label="Apply filters"
              title="Apply filters"
              data-element="apply-filters-button"
            >
              <i class="button__icon ti ti-filter-check"></i>
              <span class="button__name">Apply</span>
            </button>
            <button
              class="button button--primary button--cancel-filters"
              type="button"
              aria-label="Cancel filters"
              title="Cancel filters"
              data-element="cancel-filters-button"
            >
              <i class="button__icon ti ti-filter-cancel"></i>
              <span class="button__name">Cancel</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="loader">
      <div class="loader__spinner"></div>
      <div class="loader__title"></div>
    </div>
  </body>
</html>
