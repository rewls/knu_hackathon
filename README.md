# 북스비(Booxby)

## 0.  Welcome to [북스비](https://bulgogi.gabia.io/)!

- 스마트한 도서관 이용을 위한 **북스비**!

- 원하는 도서를 쉽고 빠르게 찾아주는 웹서비스를 제공합니다!

- by 언양식 불고기 (김다진, 김유준, 박지원, 심준성)

  - 벡엔드 : 박지원 feat. 김다진, 심준성

  - 프론트엔드 : 김유준, 심준성

  - 지도 제작 : 김다진

## 1. about 북스비

#### 1. 0. 개발 배경

COVID-19로 외출할 때 사람이 많은 곳을 피하고 외출 시간을 줄이는 것이 생활습관처럼 굳어졌습니다. 도서관에서 책을 빌려 읽고 싶지만 많은 사람이 드나드는 도서관에 오래 머무는 것은 우려될 수밖에 없습니다. 책만 빌려 나가는 것도 쉽지 않습니다. 도서관 구조가 복잡해 책을 찾는 데 많은 시간이 걸리고 이 과정에서의 접촉은 필연적이죠. 이에 저희는 **도서관 내에서의 접촉을 최소화하고 머무르는 시간을 줄이는 웹 서비스**를 개발하게 되었습니다.



#### 1.1. 기능

- 경북대학교 중앙도서관 내의 도서를 검색할 수 있습니다.

- 관심도서를 설정하여 저장할 수 있습니다.

- 도서관에 게시되어 있는 다양한 형태의 지도와 도서관에서 직접 파악한 구조를 바탕으로 제작한 지도 통합본을 제공합니다.

- 관심도서를 바탕으로 도서관 입구부터 책이 있는 서가, 대출반납데스크까지의 최단 경로를 추천해줍니다.

  

#### 1.2. 북스비는 아래와 같은 분들께 도움을 드립니다!

* 도서관 내에 머무는 시간을 줄이고 싶은 분
* 도서관 내에서의 접촉을 최소화 하고 싶은 분
* 도서관을 처음 이용하는 분
* 복잡한 구조로 인해 도서관을 쉽사리 이용하지 못했던 분
* 각기 다른 곳에 있는 도서들을 대출하려는 분



#### 1.3. 기대 효과

- 도서관 내에서의 접촉을 최소화하고 도서관 내에 머무는 시간이 줄어들어 바이러스의 위험에서 조금이나마 벗어날 수 있을 것입니다.

- 통합된 지도를 통해 도서관 이용의 편의가 증진될 것입니다.

- 도서관 접근성이 높아지며 독서에 대한 진입장벽이 낮아져 코로나로 인해 생긴 여가 시간을 독서를 통해 지식을 함유하는 시간으로 활용할 수 있습니다.

  

## 2. about 북스비 웹 구현

#### 2.1. 도서 검색

**![img](https://lh4.googleusercontent.com/6wfqqDBXXWQU5ERHOA1u17xqV0oww4yTZ6M4sOJhobrB8ENHsu7zw73VXEgqm5NAWSaLj6aD7uJTBVT52FdhajJGMrzqpIkNMj-l56bS-lGiLbQWJqBjcvLzOrmq4GI-62SoSAuj)**

- 특정 검색조건을 지정하여 도서를 검색할 수 있다.
- 검색된 도서의 청구기호와 지은이, 출판사, 중앙도서관 소장여부와 대출 상태등 상세한 정보를 알 수 있다.
- 상세정보를 통해 도서가 위치한 층수와 서가번호, 보유 권수를 알 수 있다.

#### 2.2 관심도서 저장 기능

**![img](https://lh3.googleusercontent.com/q8YuzpWSUwba5XNGhhXyaAEUpN7ismjE4ffGzXJKtBew_I1mEDzs7EsYlNtzaajOqqzXY53D_c4cr_GVZETZ7p5tmCzStfBXyig4_LLT_WaKQv23HG7Vef1sXC7T1c2OJS4nJCYx)**

- 관심있는 도서를 위시리스트에 담을 수 있고, 담긴 도서를 바탕으로 경로를 탐색해준다.
- 추가한 순서에 따라 정렬하거나 가나다순에 따라 정렬할 수 있으며 창을 닫아도 일정기간 동안 보관된다. 

#### 2.3 경로 탐색 기능

![img](https://lh6.googleusercontent.com/t0FOP1OXnzN_K9jOEf453JoCgp0GuQmJcQPY8DSYdUsABYvWWMvK7nsUZ5VY5dCxebd5stqhHFgsCT7aixjMedPfdk3zqkajmk7MQIDE35DWE6_WsvK3nuppMzQtfkeomNcW9_Ks)

- 도서들을 효율적으로 빌릴 수 있는 동선을 탐색한다.
- 가야할 지점에 대해 선을 이어 시각적으로 사용자에게 길을 안내한다.
- 청구기호를 보고 책을 찾아야했던 기존 방식과 달리 지도를 이용하여 책을 찾아 책을 찾는 시간이 단축된다.

## 3. about 북스비 개발

#### 3.0. 개발 환경

* WEB : HTML, CSS, JavaScript, PHP
* Algorithm : C, Python

#### 3.1. 지원 브라우저

IE를 제외한 모든 브라우저를 지원합니다.

#### 3.2 API

##### 1. 도서 검색 API

- 요청 URL : https://bulgogi.gabia.io/API/book_search.php

- 메서드 : POST
- 출력 포맷 : JSON
- 요청 변수

| Key    | Type   | Description                                                  | Required |
| ------ | ------ | ------------------------------------------------------------ | -------- |
| type   | string | 전체 : "all", 제목 : "title", 저자 : "author", 출판사 : "publisher" (in english) | O        |
| name   | string | 검색어                                                       | O        |
| max    | int    | 한번에 받아올 검색 결과 개수                                 | O        |
| offset | int    | n번째 검색 결과부터 검색                                     | O        |

- 출력 결과

| Key            | Type    | Description                                                  |
| -------------- | ------- | ------------------------------------------------------------ |
| success        | boolean | 성공여부                                                     |
| isFuzzy        | boolean | 검색된 결과는 없으나 유사어로 검색한 결과가 있으면 true, 보통은 false |
| totalCountlist | int     | 총 검색 결과                                                 |
| **list**       | array   | 검색된 도서 정보                                             |

| list | Key         | Type   | Description                              |
| ---- | ----------- | ------ | ---------------------------------------- |
|      | id          | int    | 서고 위치 검색용 코드                    |
|      | imgUrl      | string | 책 썸네일                                |
|      | title       | string | 책 제목                                  |
|      | author      | string | 저자                                     |
|      | publication | string | 출판사                                   |
|      | code        | string | 도서 분류 번호                           |
|      | location    | string | 도서 보관 위치 (중앙도서관, 의학분관 등) |
|      | state       | string | 상태 (대출가능, 대출중, 열람가능 등)     |



##### 2. 도서 위치 API

- 요청 URL : https://bulgogi.gabia.io/API/book_location.php
- 메서드 : GET, POST
- 출력 포맷 : JSON
- 요청 변수

| Key  | Type | Description                                  | Required |
| ---- | ---- | -------------------------------------------- | -------- |
| id   | int  | 책 아이디 (도서 검색 API의 list에 포함된 id) | O        |

- 출력 결과

| Key      | Type    | Description                                          |
| -------- | ------- | ---------------------------------------------------- |
| succcess | boolean | 성공여부                                             |
| isJungDo | boolean | 중앙도서관에 존재하는 도서일 경우 true, 아니면 false |
| **list** | array   | 검색된 도서 위치                                     |

| Key      | Type   | Description                                  |
| -------- | ------ | -------------------------------------------- |
| code     | string | 도서 분류 코드(교차 검증용)                  |
| location | string | 책 위치 (4층 자연과학자료실, 1층 베스트셀러) |
| state    | string | 상태 (대출가능, 대출중, 열람가능 등)         |
| shelf    | string | 서고 번호                                    |



##### 3. 찜 추가 API

- 요청 URL : https://bulgogi.gabia.io/API/wishlist_add.php
- 메서드 : POST
- 출력 포맷 : JSON
- 요청 변수

| Key  | Type           | Desciption                                                   | Required |
| ---- | -------------- | ------------------------------------------------------------ | -------- |
| book | stringify JSON | "{id: , imgUrl: ,title:, author: , publication: , code: , location: ,state: }" | O        |

- 출력 결과

| success | boolean | 성공여부                               |
| :------ | ------- | -------------------------------------- |
| Key     | Type    | Description                            |
| count   | int     | 현재 찜 개수                           |
| error   | string  | null or "20개까지만 찜 할 수 있습니다" |



##### 4. 찜 삭제 API

- 요청 URL : https://bulgogi.gabia.io/API/wishlist_del.php

- 메서드 : POST

- 출력 포맷 : JSON

- 요청 변수

| Key  | Type | Description           | Required |
| ---- | ---- | --------------------- | -------- |
| id   | int  | 서고 위치 검색용 코드 | O        |

- 출력 결과

| Key     | Type    | Description                  |
| ------- | ------- | ---------------------------- |
| success | boolean | 성공여부                     |
| count   | int     | 현재 찜 개수                 |
| error   | string  | null or "해당 id가 없습니다" |



##### 5. 찜 전체 삭제 API

- 요청 URL : https://bulgogi.gabia.io/API/wishlist_del_all.php
- 메서드 : POST
- 출력 포맷 : JSON
- 요청 변수 : 없음

- 출력 결과

| Key     | Type    | Description |
| ------- | ------- | ----------- |
| success | boolean | 성공여부    |
| error   | string  | null        |



##### 6. 찜 목록 불러오기 API

- 요청 URL : https://bulgogi.gabia.io/API/wishlist_read.php
- 메서드 : POST
- 출력 포맷 : JSON
- 요청 변수 : 없음

- 출력 결과

| Key      | Type    | Description    |
| -------- | ------- | -------------- |
| success  | boolean | 성공여부       |
| count    | int     | 현재 찜 개수   |
| error    | string  | Null           |
| **list** | array   | 찜한 도서 목록 |

| Key         | Type   | Description                             |
| ----------- | ------ | --------------------------------------- |
| id          | int    | 서고 위치 검색용 코드                   |
| imgUrl      | string | 책 썸네일                               |
| title       | string | 책 제목                                 |
| author      | string | 저자                                    |
| publication | string | 출판사                                  |
| code        | string | 도서 분류 번호                          |
| location    | string | 도서 보관 위치(중앙도서관, 의학분관 등) |
| state       | string | 상태(ex. 대출가능, 대출중, 열람가능 등) |

##### 7. 전체적인 경로 찾기 API

##### 8. 층 내부에서 경로 찾기 API

##### 9. 7, 8을 합쳐 경로를 출력하는 API

## 4. 아쉬운 점

- 2, 3, 4층 모두 경로 찾기 알고리즘을 구현하려 했지만 2층까지만 구현하게 되었습니다.

## 시연 영상

<iframe width="560" height="315" src="https://www.youtube.com/embed/dpebjEuDVBE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
