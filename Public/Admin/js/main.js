/**
 * 主要业务逻辑相关
 */
var userUID = readCookie("uid")
// console.log('userUID='+userUID);
// console.log('sdktoken='+userUID);
/**
 * 实例化
 * @see module/base/js
 */
var yunXin = new YX(userUID)


