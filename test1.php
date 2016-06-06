<?php
require __DIR__ . '/vendor/autoload.php';
use Alambic\Alambic;

$connectors = [
  "mySimpleDB" => [
    "connectorClass" => "Alambic\Connector\Json",
    "basePath" => "./data/"
  ]
];

$userModel = [
  // Use a unique model name
  "name" => "User",
  // Whatever model description you want
  "description" => "Writers",
  // Fields list
  "fields" => [
    // The 'id' field
    "id" => [
      "type" => "String",
      "required" => true,
      "description" => "User Id"
    ],
    // The 'name' field
    "name" => [
      "type" => "String",
      "description" => "User Name"
    ],
    // We add a relational field stored in another type
    "posts" => [
      "type" => "Post",
      // The relation can be hasOne or hasMany like here
      "multivalued" => true,
      // We can only query the text of the post
      "args" => [
        "text" => [
          "type"=> "String"
        ]
      ],
      // The foreign key is the "author" field in the Post type
      "relation" => [
        "author" => "id"
      ]
    ]
  ],
  // Can we query this model directly?
  "expose" => true,
  // The single endpoint allows to request for one user at a time
  "singleEndpoint" => [
    "name" => "user",
    // This endpoint only takes a user Id as an argument
    "args" => [
      "id" => [
        "type" => "String",
        "required" => true,
        "description" => "User Id"
      ]
    ]
  ],
  "multiEndpoint" => [
    "name" => "users"
  ],
  // The connector used to fetch/write the data
  "connector" => [
    "type" => "mySimpleDB",
    "configs" => [
      "fileName" => "users.json"
    ]
  ]
];

$postModel = [
  "name" => "Post",
  "description" => "Blog Posts",
  "fields" => [
    "id" => [
      "type" => "String",
      "required" => true,
      "description" => "Post Id"
    ],
    "text" => [
      "type" => "String",
      "description" => "Post Text"
    ],
    "author" => [
      "type" => "String",
      "description" => "Author Id"
    ]
  ],
  "expose" => true,
  "singleEndpoint" => [
    "name" => "post",
    "args" => [
      "id" => [
        "type" => "String",
        "required" => true,
        "description" => "Post Id"
      ]
    ]
  ],
  "multiEndpoint" => [
    "name" => "posts"
  ],
  "connector" => [
    "type" => "mySimpleDB",
      "configs" => [
        "fileName" => "posts.json"
      ]
    ]
  ];

  $alambicConfig=[
    "alambicConnectors" => $connectors,
    "alambicTypeDefs" => [
      "User" => $userModel,
      "Post" => $postModel
    ]
  ];

  $data = $_GET;

  $requestString = isset($data['query']) ? $data['query'] : null;

  $alambic = new Alambic($alambicConfig);

  $result = $alambic->execute($requestString);

  header('Content-Type: application/json');
  echo json_encode($result);
