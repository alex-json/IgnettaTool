# IgnettaTool
With this CLI tool you can easy translate your web proyect made with Codeigniter 3 or 4.
The process take all the php files contained in your origin language folder and generates a new target language folder with all the files translated.
# Use instructions
## Requeriments
- composer
- php >= 7.4
## Installation
1. Clone the repository
~~~
git clone https://github.com/AlexSade/IgnettaTool.git
~~~
2. Go inside the folder
~~~
cd ./IgnettaTool
~~~
4. Install the required packages
~~~
composer install
~~~
5. Luch the tool
~~~
php ignetta.php --help
~~~
## Translations option
With de -s option you can choose between three translation services:
- **test**: Very useful for test the tool. It translate all your phrases to FakeTranslation.
- **free**: The free google translation service. It have a limited number of petitions.
- **google**: The Google Translate API for use it you need a google api key, you can use it with de -k option.
