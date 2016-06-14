describe('Update meal owner', function () {

    it('should show update form with correct values', function () {
        browser.get('http://screening.dev/');

        browser.actions().mouseMove(element(by.css('.user-change-text'))).perform();
        element(by.id('meals_owner_edit')).click();

        expect(element(by.model('updating_user.name'))
            .getAttribute('value')).toEqual('John Warner');
        expect(element(by.model('updating_user.email'))
            .getAttribute('value')).toEqual('e2e_user1@test.com');
        expect(element(by.model('updating_user.calories_per_day'))
            .getAttribute('value')).toEqual('2000');
    });


    it('should show error if user tries to set already used email', function () {
        element(by.model('updating_user.email')).clear().sendKeys('user1@test.com');
        element(by.id('user_update_submit')).click();

        expect(element(by.binding('modalUserFormErrors')).getText())
            .toEqual('The email has already been taken.');
    });


    it('should show success message after correct update', function () {
        element(by.model('updating_user.email')).clear().sendKeys('e2e_temp@test.com');
        element(by.model('updating_user.name')).clear().sendKeys('Steve Richards');
        element(by.model('updating_user.calories_per_day')).clear().sendKeys('300');
        element(by.id('user_update_submit')).click();

        expect(element(by.binding('modalUserFormSuccess')).getText())
            .toEqual('Information successfully updated');
        expect(element(by.binding('modalUserFormErrors')).getText())
            .toEqual('');

        // close form
        element(by.id('user_form_close_button')).click();
    });


    it('should update data in the navbar and table title', function () {
        expect(element(by.binding('current_user.name')).getText())
            .toEqual('Steve Richards');
        expect(element(by.binding('meals_owner.name')).getText())
            .toEqual('Steve Richards');
        expect(element(by.binding('meals_owner.calories_per_day')).getText())
            .toEqual('300');
    });


    it('should be updated if we open the form once more', function () {
        browser.actions().mouseMove(element(by.css('.user-change-text'))).perform();
        element(by.id('meals_owner_edit')).click();

        expect(element(by.model('updating_user.name'))
            .getAttribute('value')).toEqual('Steve Richards');
        expect(element(by.model('updating_user.email'))
            .getAttribute('value')).toEqual('e2e_temp@test.com');
        expect(element(by.model('updating_user.calories_per_day'))
            .getAttribute('value')).toEqual('300');

        // close form
        element(by.id('user_form_close_button')).click();
    });

});