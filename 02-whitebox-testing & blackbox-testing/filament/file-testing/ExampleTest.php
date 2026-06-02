<?php

test('homepage redirects correctly', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
});
