<?php

test('home page loads successfully', function () {
    $response = $this->get(route('home'));
    $response->assertStatus(200);
}); 