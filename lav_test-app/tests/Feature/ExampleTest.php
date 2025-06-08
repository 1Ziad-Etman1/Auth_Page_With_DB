<?php

test('the application returns a successful response', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});
