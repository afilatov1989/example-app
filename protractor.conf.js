exports.config = {
    framework: 'jasmine',
    chromeOnly: true,
    chromeDriver: 'node_modules/protractor/selenium/chromedriver_2.21',
    seleniumServerJar: 'node_modules/protractor/selenium/selenium-server-standalone-2.52.0.jar',
    specs: [
        'tests_e2e/auth/*',
        'tests_e2e/meals_crud/*',
        'tests_e2e/users_crud/*'
    ],
    jasmineNodeOpts: {
        showColors: true
    }
};
