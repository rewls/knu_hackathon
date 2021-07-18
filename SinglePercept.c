/* 
#제작자: 김유준
#제목: 단층 퍼셉트론
#목적: (x,y) 선형 분리
#Email: kinggodyujun@naver.com
*/

#include <stdio.h> //표준 입출력 헤더
#include <stdlib.h> //표준 라이브러리 헤더
#include <time.h> // 랜덤 함수 (시간 헤더)
#include <math.h> //지수 계산 함수

double weight[2]; //가중치 * 2개로 제한
double bias = -1; //편향 기본값 = -1

double Sigmoid(double x)  //Activate Function
{
	return 1 / (1 + exp(-x));
}

double compute(int x, int y) //계산 함수
{
	int temp[2]; //X,Y 값 저장 임시 배열
	double InputSum = 0.0; //가중합 변수
	int i = 0; //반복문 제어 변수 i

	temp[0] = x; //초기화
	temp[1] = y; // "

	for (i = 0; i < 2; i++) // 가중합
	{
		InputSum += weight[i] * temp[i];
	}

	return Sigmoid(InputSum + bias); // Sigmoid(가중합+편향)
}

int main(void)
{
	clock_t start1, end1; // 시작, 종료 시간 측정 변수
	float res1; // 실행 시간 저장 변수

	int inputX[4][3]; // 데이터 값(4개) InputX[n][0] = x, InputX[n][1] = y, InputX[n][2] = guess
	double a = 0.5; // 학습 률

	int ix, iy; //임의의 좌표 X,Y
	int cloop, restudy; //학습 횟수(cloop), 재 학습 여부(restudy)

	int m; // 반복문 제어 변수 (입력 데이터 * 4)
	int i, j, k; // 반복문 제어 변수
	double rnd; //난수 값 변수
	srand((unsigned int)time(NULL)); // 난수 초기화
	rnd = rand() % 2 - 1; //난수 생성

	for (i = 0; i < 2; i++) //가중치에 난수 가중치 셋팅
	{
		weight[i] = rnd;
	}
	puts("Vector X Vector Y 기대값");
	for (m = 0; m < 4; m++) //학습 데이터 입력
	{
		scanf("%d %d %d", &inputX[m][0], &inputX[m][1], &inputX[m][2]);
	}

	puts("학습 률: ");
	scanf("%f", &a);

	while (1) //학습 & 연산 루프
	{
		puts("학습 횟수: ");
		scanf("%d", &cloop);

		start1 = clock();
		for (i = 0; i < cloop; i++) //학습 함수
		{
			for (j = 0; j < 4; j++)
			{
				double oput = compute(inputX[j][0], inputX[j][1]); //임시 결과값
				int guess = inputX[j][2]; //예상 결과값

				for (k = 0; k < 2; k++)
				{
					weight[k] += a * (guess - oput) * inputX[j][k]; // 가중치 업데이트
				}
				bias += a * (guess - oput); //편향 업데이트
			}
		}

		printf("0, 0: %f\n", compute(0, 0));
		printf("1, 0: %f\n", compute(1, 0));
		printf("0, 1: %f\n", compute(0, 1));
		printf("1, 1: %f\n", compute(1, 1));
		end1 = clock();
		res1 = (float)(end1 - start1) / CLOCKS_PER_SEC;
		printf("소요된 시간은 : %.3f 초 입니다.\nT_Start : %d T_End : %d\n", res1, start1, end1);
		printf("추가 학습 하겠습니까?\nNo: 0, Yes: 1\n");
		scanf("%d", &restudy);
		if (restudy == 0)
		{
			puts("좌표점을 입력해주세요. 입력예시 x y");
			while (1) {
				scanf("%d %d", &ix, &iy);
				printf("%f\n", compute(ix, iy));
			}
			system("pause");
			return 0;
		}
		else
		{

		}
	}

}
