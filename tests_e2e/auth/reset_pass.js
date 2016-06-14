describe('Reset Password tests', function () {

    it('should show error if incorrect email provided', function () {
        browser.get('http://screening.dev/password_reset');

        element(by.model('email')).sendKeys('wrong_email@asdf.ru');
        element(by.id('password_reset_submit')).click();

        expect(element(by.binding('error')).getText())
            .toEqual('User with this email is not found');
    });

    it('should show success message if user with provided email exists', function () {
        browser.get('http://screening.dev/password_reset');

        element(by.model('email')).sendKeys('user30@test.com');
        element(by.id('password_reset_submit')).click();

        expect(element(by.binding('success')).getText())
            .toEqual('New credentials were sent to your email');
    });

});