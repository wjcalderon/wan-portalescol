@Library('utils@master') _
import com.lmig.intl.cloud.jenkins.util.EnvConfigUtil

countryParams = new EnvConfigUtil().getCountryEnvDetails(env.JOB_NAME)
def customWorkerImages = ['php=container-images.lmig.com/docker/o7820428/drupal9_php8:0.9.8']

pipeline {
    agent {
        kubernetes {
            yaml pod(mode:'Declarative', workers:customWorkerImages)
        }
    }

    environment {
        appEnv = "${countryParams.countryEnv}"
        appCountry = "${countryParams.countryCode}"
        zipFileName = "function.zip"
        exclude = "-x '*.git*' README.md composer.lock prod_Jenkinsfile app.json .editorconfig Jenkinsfile"
        appName = ""
    }

    stages {

        stage("Read app.json") {
            steps {
                script {
                    props = readJSON file: 'app.json'
                    appName =  props.appName
                    deployJob = props.deployJob
                    trouxuid = props.trouxuid

                    echo "appName.................: ${appName}"
                    echo "deployJob...............: ${props.deployJob}"
                    echo "trouxuid................: ${props.trouxuid}"
                }
            }
        }

        
        stage("Compose Install") {
            steps {
                container("php") {
                    sh 'composer install --optimize-autoloader --no-dev'
                    sh 'ls -lh'
                }
            }
        }

        stage("Sonar") {
            steps {
                script {
                   def codeSources = '.'
                   def SonarProjectKey = "${appName}"
                   def packageVersion = '0.0.1' //para dev el build, para nonprod el tag
                    withSonarQubeEnv('sonarqube') {
                        sh "ls -la"
                        echo "sonarSources: ${codeSources}"
                        echo "sonarProjectName: ${appName}"

                        sh "sonar-scanner -Dsonar.projectKey=${SonarProjectKey} -Dsonar.projectName=${appName} -Dsonar.projectVersion=${packageVersion} -Dsonar.sources=${codeSources}"                      
                    }
                }
            }
        }
        stage('zip Function') {	
            steps{
                script{
                    sh "zip -r ${zipFileName} . ${exclude}"
                }
            }
        }

        stage('artifactory upload dev/nonprod build') {
            when {
                expression {
                    return appEnv == "nonprod";
                }
            }
            steps{
                script{
                    artifacts = [
                        "${zipFileName}",
                        'prod_Jenkinsfile',
                        'app.json'
                    ]
                    artifactoryUploadFiles files: artifacts, version: CodeVersion
                }
            }
        }

        stage('Call devops job in dev') {
            when {
                expression {
                    return appEnv == "dev";
                }
            }
            steps{
                build job: deployJob, wait: false, parameters: [[$class: 'StringParameterValue', name: 'CommitIdFromDevelopBranch', value: env.GIT_COMMIT]]
            }
        }
    }
}
