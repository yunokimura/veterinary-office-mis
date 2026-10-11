// Pet Breed Data
// Used by pet_registration_form.blade.php

// Cat breeds list
const catBreeds = [
    "Puspin", "Abyssinian", "Aegean", "American Bobtail", "American Curl", 
    "American Shorthair", "American Wirehair", "Arabian Mau", "Australian Mist", "Balinese", 
    "Bambino", "Bengal", "Birman", "Bombay", "British Longhair", "British Shorthair", 
    "Burmese", "Burmilla", "California Spangled", "Chantilly-Tiffany", "Chartreux", 
    "Chausie", "Cheetoh", "Colorpoint Shorthair", "Cornish Rex", "Cymric", "Devon Rex", 
    "Donskoy", "Egyptian Mau", "Exotic Shorthair", "Havana Brown", "Highlander", 
    "Himalayan", "Japanese Bobtail", "Javanese", "Khao Manee", "Korat", "Kurilian Bobtail", 
    "LaPerm", "Lykoi", "Maine Coon", "Manx", "Mexican Hairless", "Minskin", "Minuet", 
    "Munchkin", "Nebelung", "Norwegian Forest Cat", "Ocicat", "Ojos Azules", 
    "Oriental Shorthair", "Persian", "Peterbald", "Pixiebob", "Ragamuffin", "Ragdoll", 
    "Russian Blue", "Savannah", "Scottish Fold", "Scottish Straight", "Selkirk Rex", 
    "Serengeti", "Siamese", "Siberian", "Singapura", "Snowshoe", "Somali", "Sphynx", 
    "Thai", "Tonkinese", "Toybob", "Toyger", "Turkish Angora", "Turkish Van", 
    "York Chocolate", "Unknown"
];

// Dog breeds list (full list)
const dogBreeds = [
    "Aspin", "Akita", "Alaskan Klee Kai", "Alaskan Malamute", "American Eskimo", 
    "Appenzeller Sennenhund", "Australian Stumpy Tail Cattle Dog", "Azawakh", "Barbado da Terciera", "Barbet", "Basenji",
    "Basset Fauve de Bretagne", "Basset Hound", "Beagle", "Belgian Laekenois", "Belgian Tervuren", 
    "Berger Picard", "Bichon Frise", "Bloodhound", "Boerboel", "Bolognese", "Borzoi", "Boxer", 
    "Bracco Italiano", "Braque Francais Pyrenean", "Braques du Bourbonnais", "Broholmer", 
    "Brussels Griffon", "Bull Terrier", "Boston Bull Terrier", "Staffordshire Bull Terrier", 
    "Miniature Bull Terrier", "Bulldog", "French Bulldog", "Olde English Bulldogge", 
    "American Bulldog", "Continental Bulldog", "Ca de Bou", "Serrano Bulldog", "Campeiro Bulldog", 
    "Alano Español", "Canaan Dog", "Canadian Eskimo Dog", "Cane Corso", "Carolina Dog", 
    "Catahoula Leopard", "Cesky Fousek", "Chihuahua", "Chinese Crested", "Chinese Shar-Pei", 
    "Chinook", "Chow Chow", "Cirneco dell'Etna", "American English Coonhound", 
    "Black and Tan Coonhound", "Bluetick Coonhound", "Redbone Coonhound", "Treeing Walker Coonhound", 
    "Plott Hound", "Cardigan Welsh Corgi", "Pembroke Welsh Corgi", "Coton de Tulear", 
    "Czechoslovakian Vlcak", "Dachshund", "Dalmatian", "Danish-Swedish Farmdog", 
    "Deutscher Watchtelhund", "Dogo Argentino", "Dogue de Bordeaux", "Drever", "Dutch Partridge", 
    "Dutch Smoushond", "East Siberian Laika", "Eurasier", "Finnish Spitz", "American Foxhound", 
    "English Foxhound", "German Spitz", "Grand Basset Griffon Vendeen", "Grand Bleu de Gascogne", 
    "Great Dane", "Great Pyrenees", "Greenland Dog", "Hanoverian Scenthound", "Harrier", 
    "Havanese", "Hokkaido", "Afghan Hound", "American Leopard Hound", 
    "Bavarian Mountain Scent Hound", "Caravan (Mudhol) Hound", "Finnish Hound", 
    "French White & Black Hound", "German Hound", "Hamilton Hound", "Ibizan Hound", 
    "Pharaoh Hound", "Transylvanian Hound", "Hovawart", "Irish Wolfhound", "Italian Greyhound", 
    "Japanese Akitainu", "Japanese Chin", "Japanese Spitz", "Jindo", "Kai Ken", 
    "Karelian Bear Dog", "Keeshond", "Kishu Ken", "Komondor", "Kromfohrlander", "Kuvasz", 
    "Lagotto Romagnolo", "Lancashire Heeler", "Lapponian Herder", "Leonberger", "Lhasa Apso", 
    "Lowchen", "Maltese", "Standard Manchester Terrier", "Toy Manchester Terrier", "Mastiff", 
    "Bullmastiff", "Brazilian Mastiff", "Neapolitan Mastiff", "Pyrenean Mastiff", 
    "Spanish Mastiff", "Tibetan Mastiff", "Moscow Watchdog", "Mountain Cur", "Bernese Mountain Dog", 
    "Entlebucher Mountain Dog", "Estrela Mountain Dog", "Greater Swiss Mountain Dog", "Mudi", 
    "Newfoundland", "Norrbottenspets", "Norwegian Buhund", "Norwegian Elkhound", 
    "Norwegian Lundehund", "Otterhound", "Pekingese", "Perro de Presa Canario", "Peruvian Inca Orchid", 
    "Petit Basset Griffon Vendeen", "Affenpinscher Pinscher", "Doberman Pinscher", 
    "German Pinscher", "Miniature Pinscher", "German Longhaired Pointer", "German Shorthaired Pointer", 
    "German Wirehaired Pointer", "Portuguese Pointer", "Slovakian Wirehaired Pointer", 
    "Chart Polski Polish Greyhound", "Pomeranian", "Miniature Poodle", "Standard Poodle", 
    "Toy Poodle", "Porcelaine", "Portuguese Podengo", "Portuguese Podengo Pequeno", 
    "Pudelpointer", "Pug", "Puli", "Pumi", "Rafeiro do Alentejo", "Chesapeake Bay Retriever", 
    "Curly-coated Retriever", "Flat-Coated Retriever", "Golden Retriever", "Labrador Retriever", 
    "Nova Scotia Duck Tolling Retriever", "Rhodesian Ridgeback", "Rottweiler", "Russian Toy", 
    "Russian Tsvetnaya Bolonka", "Saint Bernard", "Saluki", "Samoyed", "Schapendoes", 
    "Schipperke", "Giant Schnauzer", "Miniature Schnauzer", "Standard Schnauzer", 
    "Scottish Deerhound", "Sealyham Terrier", "Segugio Italiano", "English Setter", 
    "Gordon Setter", "Irish Red and White Setter", "Irish Setter", "Anatolian Shepherd", 
    "Australian Cattle Dog", "American Miniature Shepherd", "Australian Kelpie Shepherd", 
    "Australian Shepherd", "Bearded Collie", "Beauceron", "Belgian Malinois", 
    "Belgian Sheepdog (Groenendael)", "Briard", "Border Collie", "Bouvier des Flandres", 
    "Collie", "Finnish Lapphund", "Miniature American Shepherd", "Bergamasco Shepherd", 
    "Bohemian Shepherd", "Catalan Shepherd", "Caucasian Shepherd", "Central Asian Shepherd", 
    "Croatian Shepherd", "Dutch Shepherd", "English Shepherd", "German Shepherd", 
    "Icelandic Shepherd", "Karst Shepherd", "Old English Shepherd", "Polish Lowland Shepherd", 
    "Portuguese Shepherd", "Pyrenean Shepherd", "Romanian Carpathian Shepherd Dog", 
    "Romanian Mioritic Shepherd Dog", "Shetland Sheepdog", "Shiba Inu", "Shih Tzu", "Shikoku", 
    "Siberian Husky", "Sloughi", "Slovensky Cubac", "Slovensky Kopov", "Small Munsterlander", 
    "American Water Spaniel", "Boykin Spaniel", "Brittany", "Cavalier King Charles Spaniel", 
    "Clumber Spaniel", "Cocker Spaniel", "English Cocker Spaniel", "English Springer Spaniel", 
    "English Toy Spaniel", "Field Spaniel", "French Spaniel", "Irish Water Spaniel", 
    "Nederlandse Kooikerhondje", "Papillon Spaniel", "Sussex Spaniel", "Tibetan Spaniel", 
    "Welsh Springer Spaniel", "Spinone Italiano", "Stabyhoun", "Swedish Vallhund", "Taiwan Dog", 
    "Airedale Terrier", "American Hairless Terrier", "American Staffordshire Terrier", 
    "Australian Terrier", "Bedlington Terrier", "Border Terrier", "Biewer Terrier", 
    "Black Russian Terrier", "Cairn Terrier", "Cesky Terrier", "Dandie Dinmont Terrier", 
    "Glen of Imaal Terrier", "Irish Terrier", "Jagdterrier", "Japanese Terrier", 
    "Kerry Blue Terrier", "Lakeland Terrier", "Norfolk Terrier", "Norwich Terrier", 
    "Parson Russell Terrier", "Rat Terrier", "Jack Russell Terrier", "Scottish Terrier", 
    "Silky Terrier", "Skye Terrier", "Smooth Fox Terrier", "Soft Coated Wheaten Terrier", 
    "Teddy Roosevelt Terrier", "Tibetan Terrier", "Toy Fox Terrier", "Welsh Terrier", 
    "West Highland White Terrier", "Wire Fox Terrier", "Thai Ridgeback", "Tornjak", "Tosa", 
    "Treeing Tennessee Brindle", "Vizsla", "Volpino Italiano", "Portuguese Water Dog", 
    "Spanish Water Dog", "Weimaraner", "Wetterhoun", "Whippet", "Wirehaired Pointing Griffon", 
    "Wirehaired Vizsla", "Working Kelpie", "Xoloitzcuintli", "Yakutian Laika", "Yorkshire Terrier", 
    "Unknown"
];

// Popular / quick-selection breeds per species
const quickDogBreeds = ['Aspin', 'Shih Tzu', 'Pomeranian', 'Golden Retriever', 'Labrador Retriever', 'Chihuahua'];
const quickCatBreeds = ['Puspin', 'Persian', 'Siamese', 'Maine Coon', 'British Shorthair', 'Ragdoll'];

// Export for module usage if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { catBreeds, dogBreeds, quickDogBreeds, quickCatBreeds };
}