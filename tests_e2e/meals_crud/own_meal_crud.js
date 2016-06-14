var moment = require('../../resources/assets/vendor/moment.js');
describe('Own meals CRUD', function () {

    /**
     * CREATE
     */

    it('should show the create form correctly', function () {
        element(by.id('create_new_meal_button')).click();

        expect(element(by.model('current_meal.date'))
            .getAttribute('value')).toEqual(moment().format('YYYY-MM-DD'));
        expect(element(by.model('current_meal.time'))
            .getAttribute('value')).toEqual(moment().format('HH:mm') + ':00.000');
        expect(element(by.model('current_meal.text'))
            .getAttribute('value')).toEqual('');
        expect(element(by.model('current_meal.calories'))
            .getAttribute('value')).toEqual('');
    });

    it('should show an error if text is too short', function () {
        element(by.model('current_meal.text')).clear().sendKeys('test');
        element(by.model('current_meal.calories')).clear().sendKeys('300');
        element(by.id('create_update_meal_submit')).click();

        expect(element(by.binding('modalMealFormErrors')).getText())
            .toEqual('The text must be at least 6 characters.');
    });

    it('should show an error if calories are below zero', function () {
        element(by.model('current_meal.text')).clear().sendKeys('test ok text');
        element(by.model('current_meal.calories')).clear().sendKeys('-300');
        element(by.id('create_update_meal_submit')).click();

        expect(element(by.binding('modalMealFormErrors')).getText())
            .toEqual('The calories must be at least 0.');
    });

    it('should close and add a meal to table, if meal is created', function () {
        element(by.model('current_meal.text')).clear().sendKeys('test ok text');
        element(by.model('current_meal.calories')).clear().sendKeys('300');
        element(by.id('create_update_meal_submit')).click();

        expect(element.all(by.css('.meals-table td.col-description')).first().getText())
            .toEqual('test ok text');
        expect(element.all(by.css('.meals-table td.col-calories')).first().getText())
            .toEqual('300');
        expect(element.all(by.css('.meals-table td.col-description')).count())
            .toEqual(1);
    });

    /**
     * FILTER
     */

    it('should not show a meal if date to is earlier', function () {
        element(by.model('date_to'))
            .sendKeys(moment().subtract(2, 'days').format('MM-DD-YYYY'));
        element(by.id('meals_filter_button')).click();

        expect(element.all(by.css('.meals-table td.col-description')).count())
            .toEqual(0);
    });

    it('should not show a meal if date from is later', function () {
        element(by.model('date_from'))
            .sendKeys(moment().add(2, 'days').format('MM-DD-YYYY'));
        element(by.model('date_to'))
            .sendKeys(moment().add(7, 'days').format('MM-DD-YYYY'));
        element(by.id('meals_filter_button')).click();

        expect(element.all(by.css('.meals-table td.col-description')).count())
            .toEqual(0);
    });

    it('should show error if date from is later than date to', function () {
        element(by.model('date_from'))
            .sendKeys(moment().add(7, 'days').format('MM-DD-YYYY'));
        element(by.model('date_to'))
            .sendKeys(moment().add(2, 'days').format('MM-DD-YYYY'));
        element(by.id('meals_filter_button')).click();

        expect(element(by.binding('filter_errors')).getText())
            .toEqual('The date-from must be before or equal to date-to.');
    });

    it('should show a meal if date range is correct and includes this meal', function () {
        element(by.model('date_from'))
            .sendKeys(moment().subtract(2, 'days').format('MM-DD-YYYY'));
        element(by.model('date_to'))
            .sendKeys(moment().add(7, 'days').format('MM-DD-YYYY'));
        element(by.id('meals_filter_button')).click();

        expect(element.all(by.css('.meals-table td.col-description')).count())
            .toEqual(1);
    });


    /**
     * UPDATE
     */

    it('should show the update form correctly', function () {
        element.all(by.css('.meals-table .fa-pencil')).first().click();

        expect(element(by.model('current_meal.text'))
            .getAttribute('value')).toEqual('test ok text');
        expect(element(by.model('current_meal.calories'))
            .getAttribute('value')).toEqual('300');
    });

    it('should show an error if text is too short', function () {
        element(by.model('current_meal.text')).clear().sendKeys('test');
        element(by.model('current_meal.calories')).clear().sendKeys('300');
        element(by.id('create_update_meal_submit')).click();

        expect(element(by.binding('modalMealFormErrors')).getText())
            .toEqual('The text must be at least 6 characters.');
    });

    it('should show an error if calories are below zero', function () {
        element(by.model('current_meal.text')).clear().sendKeys('test ok text');
        element(by.model('current_meal.calories')).clear().sendKeys('-300');
        element(by.id('create_update_meal_submit')).click();

        expect(element(by.binding('modalMealFormErrors')).getText())
            .toEqual('The calories must be at least 0.');
    });


    it('should close and update a meal in a table, if form submitted correctly', function () {
        element(by.model('current_meal.text')).clear().sendKeys('test new text');
        element(by.model('current_meal.calories')).clear().sendKeys('1500');
        element(by.id('create_update_meal_submit')).click();

        expect(element.all(by.css('.meals-table td.col-description')).first().getText())
            .toEqual('test new text');
        expect(element.all(by.css('.meals-table td.col-calories')).first().getText())
            .toEqual('1500');
    });

    /**
     * DELETE
     */

    it('should open confirmation form if we push a delete button', function () {
        element.all(by.css('.meals-table .fa-times')).first().click();

        expect(element(by.css('.delete-modal .modal-title')).getText())
            .toEqual('Are you sure?');
    });

    it('should delete the meal', function () {
        element(by.id('delete_meal_button')).click();

        expect(element.all(by.css('.meals-table td.col-description')).count())
            .toEqual(0);
    });


});

