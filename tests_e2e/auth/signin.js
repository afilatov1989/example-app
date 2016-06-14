describe('SignIn tests', function () {

    it('should show an error if wrong credentials provided', function () {
        browser.get('http://screening.dev/signin');

        element(by.model('email')).clear().sendKeys('wrong_email@asdf.ru');
        element(by.model('password')).clear().sendKeys('wrongPassword');
        element(by.id('signin_submit')).click();

        expect(element(by.binding('error')).getText())
            .toEqual('Invalid credentials');
    });

    it('should login user correctly and redirect to home page', function () {
        browser.get('http://screening.dev/signin');

        element(by.model('email')).clear().sendKeys('user1@test.com');
        element(by.model('password')).clear().sendKeys('qwerty123');
        element(by.id('signin_submit')).click();

        expect(browser.getCurrentUrl()).toEqual('http://screening.dev/');
        element(by.css('.nav-username')).click();
        element(by.id('navbar_logout')).click();
        expect(browser.getCurrentUrl()).toEqual('http://screening.dev/signin');
    });

});
