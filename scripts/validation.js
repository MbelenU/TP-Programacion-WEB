//Clases de regex
export const regexName = /^[a-zA-ZÀ-ÿ-']+\s[a-zA-ZÀ-ÿ-']+$/; // Nombre con un min de dos palabras
export const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Formato de un Email
export const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/; // Contraseña de 8 caracteres con almenos: 1 Mayúscula, 1 minúscula y 1 número. 
export const regexPhoneNumber = /^\d{10,}$/; // Numeros de telefono con 10 números de min.
//Funciones 
export function validateName(name) {
    return regex.test(name);
}
export function validateEmail(email) {
    return regexEmail.test(email);
}
export function validatePassword(password) {
    return regexPassword.test(password);
}
export function validatePhoneNumber(phoneNumber) {
    return regexPhoneNumber(phoneNumber);
}

/* Para utilizar las funciones o variables de este archivo deben:
    - Colocar en los html la siguiente sintaxtis: 
        <script type="module" src="[Path de su archivo donde van a utilizar las funciones/variables]"></script> 
    - Colocar en su archivo JS la siguiente sintaxis:
        import * as [Nombre que deseen] from '[Path del archivo validation.js]' -> Esto es para utilizar todo lo que contiene el archivo.
        import {[Nombre de las funciones que requieran separadas con una coma]} from '[Path del archivo validation.js]' -> Por si solo necesitan una o más funciones especificas.
*/