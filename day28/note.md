<!-- data type -->

<!-- primitive data type -->

Of course. Here are the brief notes on our last topic, JavaScript Data Types.

Daily Notes: Monday, October 27, 2025
Summary: JavaScript Data Types
In JavaScript, all data is divided into two main categories:

Primitive Types (Value Types)

These are simple, single values (like a brick).

They are copied by value (you get a new, separate copy).

There are 7 of them: String, Number, Boolean, undefined, null, BigInt, and Symbol.

Reference Types (Objects)

These are complex, multi-part values (like a tiffin box).

They are copied by reference (you just get a remote control to the same tiffin box).

The main type is Object.

Arrays and Functions are also special types of objects.

The "Hidden Things" (Tricks)
The typeof null Bug: If you check the type of null, the console will say "object". This is a famous, 30-year-old bug. null is a primitive, not an object.

"Autoboxing": Primitives (like a string) don't have methods, but we can still use .toUpperCase(). This is because JavaScript secretly "wraps" the string in an object temporarily just to use the method, and then throws the wrapper away.
 null : av data nhi pata kia h ane wale future me data pata chalega eslia initialize krke chhor dia h future me data mil jayga.

 boolean: true or false

 string : character 

 array 

 object 

 symbol

 number

 float 

 NaN

 Good morning! I've started a new page for today's session.

This is a fundamental and "root" concept of JavaScript. The most important "hidden" thing to know is that all data types in JavaScript are divided into two main categories.

Daily Notes: Monday, October 27, 2025
Search Topic: JavaScript Data Types (The Root Categories)
Primitive Types (Value Types): These are the simplest, most basic data types. They are immutable (meaning their value can't be changed) and are copied "by value" (like copying a solid brick).


Reference Types (Objects): This category contains only one member: Object. Everything else (Arrays, Functions) is just a special type of Object. They are mutable (can be changed) and are copied "by reference" (like copying a remote control for the same TV).

Category 1: The 7 Primitive Types
String: Used for text. Must be in quotes.

let name = "Ravi";

Number: Used for all numbers (integers and decimals).

let age = 25;

let price = 199.99;

Boolean: Represents true or false. Used for logic.

let isLoggedIn = true;

undefined: This is the default value of a variable that has been declared but not yet given a value. It means "value is not assigned."

let myVar; (Right now, myVar is undefined)

null: This is a value you intentionally assign to a variable to mean "no value" or "empty." It is a deliberate assignment of nothing.

let myVar = null;

The "Advance/Hidden" Primitives
BigInt: This is a special numeric type for whole numbers that are too large for the standard Number type to hold safely.

let veryBigNumber = 9007199254740991n; (Notice the n at the end).

Symbol: This is a "hidden" type used to create unique, anonymous identifiers for object properties. This prevents property names from clashing, which is useful in complex libraries.

let mySymbol = Symbol("description");




Good morning! I've started a new page for today's session.

This is a fundamental and "root" concept of JavaScript. The most important "hidden" thing to know is that all data types in JavaScript are divided into two main categories.

Daily Notes: Monday, October 27, 2025
Search Topic: JavaScript Data Types (The Root Categories)
Primitive Types (Value Types): These are the simplest, most basic data types. They are immutable (meaning their value can't be changed) and are copied "by value" (like copying a solid brick).


Reference Types (Objects): This category contains only one member: Object. Everything else (Arrays, Functions) is just a special type of Object. They are mutable (can be changed) and are copied "by reference" (like copying a remote control for the same TV).

Category 1: The 7 Primitive Types
String: Used for text. Must be in quotes.

let name = "Ravi";

Number: Used for all numbers (integers and decimals).

let age = 25;

let price = 199.99;

Boolean: Represents true or false. Used for logic.

let isLoggedIn = true;

undefined: This is the default value of a variable that has been declared but not yet given a value. It means "value is not assigned."

let myVar; (Right now, myVar is undefined)

null: This is a value you intentionally assign to a variable to mean "no value" or "empty." It is a deliberate assignment of nothing.

let myVar = null;

The "Advance/Hidden" Primitives
BigInt: This is a special numeric type for whole numbers that are too large for the standard Number type to hold safely.

let veryBigNumber = 9007199254740991n; (Notice the n at the end).

Symbol: This is a "hidden" type used to create unique, anonymous identifiers for object properties. This prevents property names from clashing, which is useful in complex libraries.

let mySymbol = Symbol("description");

Category 2: The Reference Type (Object)
An Object is a complex data type. Almost everything else in JavaScript that is not a primitive is a special kind of object.

Standard Object:

JavaScript

let user = {
  name: "Sita",
  age: 30
};
Array: An array is just a special object where the keys are numbers (0, 1, 2...) and it has a special length property.

JavaScript

let fruits = ["Apple", "Mango"];
Function: Even functions are "first-class objects" in JavaScript, which is why you can pass them around as variables.

"Hidden Things" & Quirks
The typeof null Bug:

If you check the type of null, JavaScript will tell you it's an "object".

console.log(typeof null); // Output: "object"

This is a 30-year-old bug in the original JavaScript that can't be fixed because it would break old websites. null is a primitive, but the typeof operator is wrong.

Primitives Behaving Like Objects (Autoboxing):

Primitives are immutable (can't be changed) and don't have methods. So how can we do this: let name = "ravi"; console.log(name.toUpperCase());?

The "Hidden" Answer: JavaScript temporarily "wraps" the primitive string ("ravi") in a String object wrapper just long enough to use the .toUpperCase() method. After the line is done, the object is thrown away. This is called "autoboxing".

Array and Function are Objects:

If you check the type of an array or function, you get:

console.log(typeof [1, 2, 3]); // Output: "object"

console.log(typeof function() {}); // Output: "function" (This is a special case typeof has for functions, but they are still objects).