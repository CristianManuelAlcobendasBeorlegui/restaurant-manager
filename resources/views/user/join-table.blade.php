<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Join a table</title>
    <link rel="stylesheet" href="{{ asset('css/join-table.css') }}" />
    <script src="{{ asset('js/join-table.js') }}"></script>
  </head>
  <body class="layout layout--join">
    <section class="page-section">  
      <div class="page-section__container">
        <h2 class="page-section__heading featured-word">Join to a table</h2>
        <p class="page-section__description">
          <span class="featured-word">Enter</span> the table code provided by
          the service chief.
        </p>
        <form class="form">
          <div class="form__element" data-form-element="code">
            <label for="join-form--code" class="form__label">Table code</label>
            <input
              type="text"
              class="form__input-field"
              id="join-form--code"
              maxlength="14"
            />
            <div class="form__element-errors"></div>
          </div>
          <fieldset class="form__options">
            <button
              class="button button--primary button--cta button--enter"
              type="button"
              data-element="validate-join-form-button"
              aria-label="Validate table code"
              title="Validate table code"
            >
              Enter
            </button>
          </fieldset>
        </form>
      </div>
    </section>
    <div class="loader">
      <div class="loader__spinner"></div>
      <strong class="loader__title">test</strong>
    </div>
  </body>
</html>
