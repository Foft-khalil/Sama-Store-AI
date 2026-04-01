<?php

$apiKey = env('GEMINI_API_KEY'); // The user didn't put it in the git repo, obviously, but I'll hit the public models list

$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . getenv('GEMINI_API_KEY');

// In local, we don't have the key, so I'll just use curl to get the list of models if it's public? 
// No, listModels requires an API key. 
// I'll output instructions for the user to run curl on their server, or I'll just change the model to 'gemini-1.5-flash-8b'.
