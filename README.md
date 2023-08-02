*thank chatGPT for documentation*
# SocialMeta Class Documentation

## Description

The `SocialMeta` class is a PHP utility for generating social media meta tags. These meta tags are used to provide information about a webpage when it is shared on social media platforms like Google+, Facebook, and Twitter. The class allows you to set various meta parameters, such as URL, title, description, and images, which are then used to generate the appropriate meta tags.

## Class Properties

- `private $fileParam`: A private variable to store the configuration parameters loaded from the `socialMeta_param.json` file.
- `const PARAM_FILE`: A constant representing the filename of the configuration file (`socialMeta_param.json`).
- `const IMG_FOLDER`: A constant representing the folder path for storing images used in social media meta tags.
- `private $commonParam`: An associative array containing common meta parameters like URL, title, and description.
- `private $SocialImages`: An associative array to store the URLs or file paths of the social media images for Google+, Facebook, and Twitter.
- `private $othersParams`: An associative array to store additional parameters like `og_type` (Open Graph type) and `twitter_card` (Twitter card type).

## Class Methods

### Private Methods

#### `private function remote_file_exists($url)`

- Description: Checks if a remote file exists using the `allow_url_fopen` setting and `file_exists` function.
- Parameters:
  - `$url` (string): The URL of the remote file to check.
- Returns:
  - `true` if the remote file exists.
  - `false` if the remote file does not exist or cannot be accessed.

#### `private function fileFind($url)`

- Description: Determines whether the given URL is a remote file or a local file and checks if the file exists.
- Parameters:
  - `$url` (string): The URL or file path to check.
- Returns:
  - The URL or file path if it exists.
  - `false` if the URL or file path does not exist.

### Public Methods

#### `public static function install()`

- Description: Installs the configuration file `socialMeta_param.json` if it does not exist.
- Parameters: None
- Returns: None
- Throws: Throws any caught exception.

#### `public function __construct(string $url, string $title, string $description)`

- Description: Class constructor used to initialize the `SocialMeta` object with the common meta parameters (`$url`, `$title`, and `$description`) and loads the configuration from the `socialMeta_param.json` file.
- Parameters:
  - `$url` (string): The URL of the webpage.
  - `$title` (string): The title of the webpage.
  - `$description` (string): The description of the webpage.
- Returns: None
- Throws:
  - Throws an exception if the `socialMeta_param.json` file is not installed or if the images folder parent is not set or does not exist, or if the default image is not set or does not exist.

#### `public function setGoogleImg(string $url)`

- Description: Sets the Google+ image URL or file path.
- Parameters:
  - `$url` (string): The URL or file path of the image to be used for Google+.
- Returns:
  - `true` if the image is set successfully.
- Throws: Throws an exception if no image is found.

#### `public function setOgImg(string $url)`

- Description: Sets the Open Graph (Facebook) image URL or file path.
- Parameters:
  - `$url` (string): The URL or file path of the image to be used for Open Graph (Facebook).
- Returns:
  - `true` if the image is set successfully.
- Throws: Throws an exception if no image is found.

#### `public function setTwitterImg(string $url)`

- Description: Sets the Twitter image URL or file path.
- Parameters:
  - `$url` (string): The URL or file path of the image to be used for Twitter.
- Returns:
  - `true` if the image is set successfully.
- Throws: Throws an exception if no image is found.

#### `public function setSameImg(string $url)`

- Description: Sets the same image for Google+, Open Graph (Facebook), and Twitter.
- Parameters:
  - `$url` (string): The URL or file path of the image to be used for all three platforms.
- Returns:
  - `true` if the image is set successfully.
- Throws: Throws an exception if no image is found.

#### `public function setOgType(string $type)`

- Description: Sets the Open Graph type.
- Parameters:
  - `$type` (string): The Open Graph type to set (e.g., "website", "article", etc.).
- Returns:
  - `true` if the Open Graph type is set successfully.
  - `false` if the provided type is empty.
- Note: This function allows an empty type, which may not be desirable, as it will set the type to an empty value.

#### `public function setTwitterCard(string $card)`

- Description: Sets the Twitter card type.
- Parameters:
  - `$card` (string): The Twitter card type to set (e.g., "summary", "summary_large_image", etc.).
- Returns:
  - `true` if the Twitter card type is set successfully.
  - `false` if the provided card is empty.
- Note: This function allows an empty card type, which may not be desirable, as it will set the card type to an empty value.

#### `public function print()`

- Description: Prints the generated social media meta tags based on the provided meta parameters and images.
- Parameters: None
- Returns: None

## How to Use

1. Install the `socialMeta_param.json` file by calling the `SocialMeta::install()` method.
2. Set the images folder parent path and the default image URL or file path in the `socialMeta_param.json` file.
3. Create a new `SocialMeta` object by passing the URL, title, and description of the webpage to the constructor.
4. Optionally, set the images and other parameters using the provided setter methods.
5. Call the `print()` method to generate and print the social media meta tags for Google+, Facebook, and Twitter.

## Example

```php
// Assuming the `SocialMeta_param.json` file is already installed and configured properly.

// Create a new SocialMeta object with common meta parameters
$meta = new SocialMeta("https://example.com", "Example Page", "This is an example page.");

// Set different images for Google+, Facebook, and Twitter
$meta->setGoogleImg("https://example.com/images/google_img.jpg");
$meta->setOgImg("https://example.com/images/facebook_img.jpg");
$meta->setTwitterImg("https://example.com/images/twitter_img.jpg");

// Set the same image for all platforms
$meta->setSameImg("https://example.com/images/common_img.jpg");

// Optionally, set other parameters
$meta->setOgType("article");
$meta->setTwitterCard("summary_large_image");

// Generate and print the social media meta tags
$meta->print();
```

Please note that this documentation is based on the provided code and may not cover all possible use cases


