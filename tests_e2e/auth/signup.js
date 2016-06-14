describe('SignUp tests', function () {

    it('should show an error if password is too short', function () {
        browser.get('http://screening.dev/signup');

        element(by.model('name')).clear().sendKeys('John Warner');
        element(by.model('email')).clear().sendKeys('e2e_user1@test.com');
        element(by.model('password')).clear().sendKeys('sh');
        element(by.id('signup_submit')).click();

        expect(element(by.binding('error')).getText())
            .toEqual('The password must be at least 6 characters.');
    });

    it('should show an error if email is already used', function () {
        browser.get('http://screening.dev/signup');

        element(by.model('name')).clear().sendKeys('John Warner');
        element(by.model('email')).clear().sendKeys('user1@test.com');
        element(by.model('password')).clear().sendKeys('qwerty123');
        element(by.id('signup_submit')).click();

        expect(element(by.binding('error')).getText())
            .toEqual('User with this email already exists');
    });

    it('should create user correctly and redirect to home page', function () {
        browser.get('http://screening.dev/signup');

        element(by.model('name')).clear().sendKeys('John Warner');
        element(by.model('email')).clear().sendKeys('e2e_user1@test.com');
        element(by.model('password')).clear().sendKeys('qwerty123');
        element(by.id('signup_submit')).click();

        expect(browser.getCurrentUrl()).toEqual('http://screening.dev/');
    });

});
