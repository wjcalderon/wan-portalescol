@Library('utils@master') _
import com.lmig.intl.cloud.jenkins.util.EnvConfigUtil

countryParams = new EnvConfigUtil().getCountryEnvDetails(env.JOB_NAME)
def customWorkerImages = ['node=artifactory-emea.aws.lmig.com/pod-templates-latam/o7820428/drupal9_php8:latest']

pipeline {
    agent {
        kubernetes {
            yaml pod(mode:'Declarative', workers:customWorkerImages)
        }
    }

    environment {
        appEnv = "${countryParams.countryEnv}"
        appCountry = "${countryParams.countryCode}"
    }

    stages {

        /*stage("Read app.json") {
            steps {
                script {
                    props = readJSON file: 'app.json'
                    appName =  props.appName
                    codeSources = props.codeSources
                    deployJob = props.deployJob
                    trouxuid = props.trouxuid

                    echo "appName.................: ${appName}"
                    echo "codeSources.............: ${codeSources}"
                    echo "deployJob...............: ${props.deployJob}"
                    echo "trouxuid................: ${props.trouxuid}"
                }
            }
        }

        stage("Read package.json") {
            steps {
                script {
                    props = readJSON file: "${codeSources}/package.json"
                    packageVersion = props.version
                    appDistFile = "${appName}-${packageVersion}.zip"
                    echo "Artifact version: ${packageVersion}"
                    echo "Zip file name: ${appDistFile}"
                }
            }
        }*/

        stage("Compose Install") {
            steps {
                container("node") {
                    sh 'composer install --optimize-autoloader --no-dev'
                    sh 'ls -lh'
                }
            }
        }

        /*stage('Validate Dev Env'){
            when {
                expression {
                    return appEnv == "dev";
                }
            }
            steps {
                script{
                    if (env.BRANCH_NAME != "master" && packageVersion.contains("beta")) {
                        packageVersion = "${packageVersion}-${currentBuild.startTimeInMillis}"
                        echo "Continue with dev build";
                    } else {
                        currentBuild.result = 'FAILURE';
                        error("Package.json version must be a beta artifact");
                    }
                }
            }
        }

        stage('Validate nonProd Env'){
            when {
                expression {
                    return appEnv == "nonprod";
                }
            }
            steps {
                script{
                    if (buildingTag() && !packageVersion.contains("beta")) {
                        echo "Continue with nonprod build";
                    } else {
                        currentBuild.result = 'FAILURE';
                        error("Package.json version must be a RELEASE artifact");
                    }
                }
            }
        }

        stage("Delete dependencies") {
            steps {
                container("node") {
                    dir(codeSources) {
                        sh 'rm -rf node_modules'
                    }
                }
            }
        }
        

        stage("Sonarqube analisys") {
            steps {
                container('sonar-scanner') {
                    withSonarQubeEnv('sonarqube') {
                        echo "sonarSources: ${codeSources}"
                        echo "sonarProjectKey: intl-cl-${appName}"
                        echo "sonarProjectName: intl-cl-${appName}"
                        sh "sonar-scanner -Dsonar.projectKey=intl-cl-${appName} -Dsonar.projectName=intl-cl-${appName} -Dsonar.projectVersion=${packageVersion} -Dsonar.sources=${codeSources}"
                    }
                }
            }
        }

        stage('artifactory upload dev/nonprod build') {
            steps{
                script{
                    echo "Deploy to ${appEnv} artifactory"
                    artifacts = [
                        "${codeSources}/package.json",
                        "${codeSources}/${appDistFile}",
                        'prod_Jenkinsfile',
                        'app.json'
                    ]
                    artifactoryUploadFiles files: artifacts, version: packageVersion
                }
            }
        }

        stage("Build release package") {
            when {
                expression {
                    return appEnv == "nonprod";
                }
            }
            steps {
                container("node") {
                    dir(codeSources) {
                        sh "rm -rf ${srcInclude}"
                        sh "npm run build:prod"
                    }
                }
                dir(codeSources) {
                    sh "zip -r ${appDistFile.minus('-rc')} ${srcInclude}"
                }
            }
        }

        stage('artifactory upload prod build') {
            when {
                expression {
                    return appEnv == "nonprod";
                }
            }
            steps{
                script{
                    echo "Deploy to ${appEnv} artifactory"
                    artifacts = [
                        "${codeSources}/package.json",
                        "${codeSources}/${appDistFile.minus('-rc')}",
                        'prod_Jenkinsfile',
                        'app.json'
                    ]
                    artifactoryUploadFiles files: artifacts, version: packageVersion
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
        }*/
    }
}