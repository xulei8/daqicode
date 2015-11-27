package main

import (
	"database/sql"
	_ "github.com/mattn/go-oci8"
	"os"
	"strings"
	"fmt"
	"log"
)

func main() {
	// 为log添加短文件名,方便查看行数


	//Oracle for go测试
	//教程网址 http://item.congci.com/item/golang-lianjie-sqlite-mysql-oracle-shujuku
	// 2015年11月26日测试成功。
	
	log.SetFlags(log.Lshortfile | log.LstdFlags)
	
	log.Println("Oracle Driver example")
	
	os.Setenv("NLS_LANG", "")
	nlsLang := os.Getenv("NLS_LANG")
	if !strings.HasSuffix(nlsLang, "UTF8") {
		i := strings.LastIndex(nlsLang, ".")
		if i < 0 {
			os.Setenv("NLS_LANG", "AMERICAN_AMERICA.AL32UTF8")
		} else {
			nlsLang = nlsLang[:i+1] + "AL32UTF8"
			fmt.Fprintf(os.Stderr, "NLS_LANG error: should be %s, not %s!\n",
				nlsLang, os.Getenv("NLS_LANG"))
		}
	}


	// 用户名/密码@实例名  跟sqlplus的conn命令类似
	db, err := sql.Open("oci8", "aaa/aaa@XE")
	if err != nil {
		log.Fatal(err)
	}
	rows, err := db.Query("select 3.14, 'foo' from dual")
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()
	
	for rows.Next() {
		var f1 float64
		var f2 string
		rows.Scan(&f1, &f2)
		log.Println(f1, f2) // 3.14 foo
	}
	rows.Close()
	
	// 先删表,再建表
	db.Exec("drop table sdata")
	db.Exec("create table sdata(name varchar2(256))")
	
	db.Exec("insert into sdata values('中文')")
	db.Exec("insert into sdata values('1234567890ABCabc!@#$%^&*()_+')")
	
	rows, err = db.Query("select * from sdata")
	if err != nil {
		log.Fatal(err)
	}

	for rows.Next() {
		var name string
		rows.Scan(&name)
		log.Printf("Name = %s, len=%d", name, len(name))
	}
	rows.Close()

	rows, err = db.Query("select STUNAME, QQ , ADDRESS ,age from stu where rownum < 24400 order by id desc ")
	if err != nil {
		log.Fatal(err)
	}

	for rows.Next() {
		var name string
		var qq string 
		var addr   string 
		var age   int 
		rows.Scan(&name,&qq , &addr , &age )
		log.Printf("Name = %s, qq =%s , %s, %d", name, qq,addr ,age )
	}
	rows.Close()
}
