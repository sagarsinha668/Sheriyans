let { local scope or function scope or block scope}
const can't be modify
var global scope
<!-- console log vs console info -->
 info me bs i ka sign aa jat a kuch kuch browser m saab me nhi ata h.

console.log
console.info
console.warn
console.table
console.error

<!-- template literal  -->

 slice -->   let splices = [0,1,2,3,4,5,6,7,8,9]
    ans = splices.splice(3,5)
    console.log(ans) // 3 4 5 6 7
 replace ---> replace only first value
 replaceall ---> change value to particular value
 split  --->  array me chamge kr deta h or "a" andr wale value to delete kr deta h. or agr "" khali ho to pure value ko ek ek char me thod deta h.





<!-- AI NOTES -->

### **JavaScript Variables & Scope**
- **let** → Block scope (only works inside `{ }`)  
- **const** → Block scope + can’t be reassigned  
- **var** → Function or global scope (old style)

---

### **Console Methods**
- `console.log()` → Normal message/output  
- `console.info()` → Informational message (shows small **ℹ️** icon in some browsers)  
- `console.warn()` → Warning message (yellow color)  
- `console.error()` → Error message (red color)  
- `console.table()` → Shows array/object data in a table format

---

### **Template Literal**
- Use backticks `` ` ``
- Can include variables easily  
  ```js
  let name = "Shiv";
  console.log(`Hello ${name}`);
  ```
  Output → `Hello Shiv`

---

### **Array & String Methods**

#### **slice()**
- Copies selected elements (does **not** change original)
  ```js
  let arr = [0,1,2,3,4,5,6,7,8,9];
  console.log(arr.slice(3,5)); // [3,4]
  ```

#### **splice()**
- Removes or adds elements (**changes** original)
  ```js
  let arr = [0,1,2,3,4,5,6,7,8,9];
  let ans = arr.splice(3,5);
  console.log(ans); // [3,4,5,6,7]
  ```

#### **replace()**
- Replaces **first** match only  
  ```js
  "apple apple".replace("apple", "orange") // "orange apple"
  ```

#### **replaceAll()**
- Replaces **all** matches  
  ```js
  "apple apple".replaceAll("apple", "orange") // "orange orange"
  ```

#### **split()**
- Converts string → array  
- Removes the part used as a separator  
  ```js
  "a-b-c".split("-") // ["a","b","c"]
  ```
- If empty string → splits each character  
  ```js
  "abc".split("") // ["a","b","c"]
  ```
