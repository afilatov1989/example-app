describe('User CRUD tests', function () {

    /**
     * FILTER
     */
    it('should correctly filter users by email', function () {
        browser.get('http://screening.dev/users');
        expect(element.all(by.css('.table-striped td.col-buttons')).count())
            .toEqual(10);

        element(by.model('filter_data.email')).clear().sendKeys('admin@test.com');
        element(by.id('users_filter_click')).click();

        expect(element.all(by.css('.table-striped td.col-buttons')).count())
            .toEqual(1);

    });

    it('should correctly filter users by name and email', function () {
        browser.get('http://screening.dev/users');

        element(by.model('filter_data.name')).clear().sendKeys('VeryStrangeName');
        element(by.id('users_filter_click')).click();

        expect(element.all(by.css('.table-striped td.col-buttons')).count())
            .toEqual(0);

    });

    it('should show all users if we provide empty filter', function () {
        browser.get('http://screening.dev/users');

        element(by.model('filter_data.email')).clear();
        element(by.model('filter_data.name')).clear();
        element(by.id('users_filter_click')).click();

        expect(element.all(by.css('.table-striped td.col-buttons')).count())
            .toEqual(10);

    });

    /**
     * CREATE
     */

    it('should open create form if we push a create button', function () {
        element(by.id('user_create_button')).click();

        expect(element(by.model('updating_user.name'))
            .getAttribute('value')).toEqual('');
        expect(element(by.model('updating_user.email'))
            .getAttribute('value')).toEqual('');
        expect(element(by.model('updating_user.calories_per_day'))
            .getAttribute('value')).toEqual('');
        expect(element(by.model('updating_user.password'))
            .getAttribute('value')).toEqual('');
    });

    it('should show error if password is too short', function () {
        element(by.model('updating_user.name')).clear().sendKeys('Ivan Ivanovich');
        element(by.model('updating_user.email')).clear().sendKeys('e2e_user2@test.com');
        element(by.model('updating_user.calories_per_day')).clear().sendKeys('4000');
        element(by.model('updating_user.password')).clear().sendKeys('test');
        element(by.model('updating_user.is_admin')).click();
        element(by.id('user_update_submit')).click();

        expect(element(by.binding('modalUserFormErrors')).getText())
            .toEqual('The password must be at least 6 characters.');
    });

    it('should show error if email is already used', function () {
        element(by.model('updating_user.name')).clear().sendKeys('Ivan Ivanovich');
        element(by.model('updating_user.email')).clear().sendKeys('user1@test.com');
        element(by.model('updating_user.calories_per_day')).clear().sendKeys('4000');
        element(by.model('updating_user.password')).clear().sendKeys('testasdaa');
        element(by.id('user_update_submit')).click();

        expect(element(by.binding('modalUserFormErrors')).getText())
            .toEqual('The email has already been taken.');
    });


    it('should show create a user if form is ok, and clean up the form', function () {
        element(by.model('updating_user.name')).clear().sendKeys('Ivan Ivanovich');
        element(by.model('updating_user.email')).clear().sendKeys('e2e_user2@test.com');
        element(by.model('updating_user.calories_per_day')).clear().sendKeys('4000');
        element(by.model('updating_user.password')).clear().sendKeys('testasdaa');
        element(by.id('user_update_submit')).click();

        expect(element(by.binding('modalUserFormSuccess')).getText())
            .toEqual('User successfully created');
        expect(element(by.model('updating_user.name'))
            .getAttribute('value')).toEqual('');
        expect(element(by.model('updating_user.email'))
            .getAttribute('value')).toEqual('');
        expect(element(by.model('updating_user.calories_per_day'))
            .getAttribute('value')).toEqual('');
        expect(element(by.model('updating_user.password'))
            .getAttribute('value')).toEqual('');

        // close create modal window
        element(by.id('user_form_close_button')).click();
    });

    /**
     * UPDATE
     */

    it('should show update form with correct values', function () {
        element(by.repeater('user in userlist').row(2))
            .all(by.css('.fa-pencil')).first().click();

        expect(element(by.model('updating_user.name'))
            .getAttribute('value')).toEqual('Ivan Ivanovich');
        expect(element(by.model('updating_user.email'))
            .getAttribute('value')).toEqual('e2e_user2@test.com');
        expect(element(by.model('updating_user.calories_per_day'))
            .getAttribute('value')).toEqual('4000');

        expect(element(by.model('updating_user.is_admin')).isSelected()).toBeTruthy();

    });

    it('should correctly update the user', function () {
        element(by.model('updating_user.name')).clear().sendKeys('Petr Petrovich');
        element(by.model('updating_user.email')).clear().sendKeys('e2e_user3@test.com');
        element(by.model('updating_user.calories_per_day')).clear().sendKeys('5200');

        element(by.id('user_update_submit')).click();
        expect(element(by.binding('modalUserFormSuccess')).getText())
            .toEqual('Information successfully updated');

        // close update modal window
        element(by.id('user_form_close_button')).click();

        expect(element(by.repeater('user in userlist').row(2))
            .all(by.css('.col-user-name')).first().getText()).toEqual('Petr Petrovich');
        expect(element(by.repeater('user in userlist').row(2))
            .all(by.css('.col-user-email')).first().getText()).toEqual('e2e_user3@test.com');
        expect(element(by.repeater('user in userlist').row(2))
            .all(by.css('.col-user-cal-per-day')).first().getText()).toEqual('5200');
    });


    /**
     * DELETE
     */

    it('should open confirmation form if we push a delete button', function () {

        element(by.repeater('user in userlist').row(1))
            .all(by.css('.fa-times')).first().click();

        expect(element(by.css('.delete-modal .modal-title')).getText())
            .toEqual('Are you sure?');
    });

    it('should correctly delete user', function () {
        element(by.id('user-delete-button')).click();

        // delete the second created user without test to cleanup the database
        element(by.repeater('user in userlist').row(1))
            .all(by.css('.fa-times')).first().click();
        element(by.id('user-delete-button')).click();

        expect(element(by.repeater('user in userlist').row(1))
            .all(by.css('td.col-user-email')).first().getText())
            .toEqual('manager@test.com');

    });

});
