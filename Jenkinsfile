@Library('utils@master') _
import com.lmig.intl.cloud.jenkins.util.EnvConfigUtil

node('linux'){
    envUtil = new EnvConfigUtil();
    def countryParams = envUtil.getCountryEnvDetails(env.JOB_NAME);
    def AppEnv = countryParams.countryEnv
    def AppCountry = countryParams.countryCode

    stage('Git Checkout'){
        checkout scm
    }

    stage('Install Libraries'){
        withAWS(credentials:'aws-cred') {
            dir('.'){
                sh 'pip install docker-compose'
                sh 'docker-compose -v'
                sh 'composer install --optimize-autoloader --no-dev'
                sh 'ls -lh'
            }
        }
    }
}