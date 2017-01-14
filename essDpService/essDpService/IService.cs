using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;
using System.Data;

namespace essDpService
{
    // NOTE: You can use the "Rename" command on the "Refactor" menu to change the interface name "IService" in both code and config file together.
    [ServiceContract]
    public interface IService
    {
        [OperationContract]
        string DataTableToJSONWithJavaScriptSerializer(DataTable table);


        //USER ACCOUNT MANAGEMENT
            //registration process
            [OperationContract]
            String checkUniqueUserNAV(String personID);//checks if employee ID exists in Navision

            [OperationContract]
            String checkExistenceInESSDB(String personID);//checks if employee ID is tied to an account on ESS

            [OperationContract]
            String registerUser(String essUser, String personID, String password, String firstTimeLoiginID);
            //registration process

            //login process
            [OperationContract]
            String checkPasswordChange(String PersonID);//checks if a password change request exists

            [OperationContract]
            String firstTimeLoginCheck(String PersonID);

            [OperationContract]
            String loginUser(String essUser, String personID, String password);

            [OperationContract]
            String ftloginUser(String essUser, String personID, String password, String ftloginCode);
            //login process

            //change password process
            [OperationContract]
            String saveTempPass(String PersonID, String tempPass);

            [OperationContract]
            String checkResetPassword(String empNo, String resetCode);//checks if the reset code matches the code associated with a particular employee ID

            [OperationContract]
            String updateNewPassword(String empNo, String newpass);//deletes existing tempPass and updates new password
            //change password process
        //USER ACCOUNT MANAGEMENT

        //LEAVE MANAGEMENT
        [OperationContract]
            String submitLeaveRequest(String PersonID, String FromDate, String ToDate, String CauseOfAbsence, Int32 NoOfDays, String ApproversPersonID, String FinalApproversPersonID, String Year, String daysRemaining, String leaveGroupCode, String status, Int32 totalDaysApplied);

        [OperationContract]
        String getPendingRequests(String ApproversPersonID);

        [OperationContract]
        String approveRequest(String RequestID, String comment, String status);

        [OperationContract]
        String getUserLeaveApplication(String PersonID);

        [OperationContract]
        String denyApproval(String RequestID, String Comment);

        [OperationContract]
        String getEntitlements(String PersonID, String LeaveGroupCode, String LeaveYear);

        [OperationContract]
        String getLeaveRequestFromNAV(String personID, String COA, String leaveYear);

        [OperationContract]
        String getLeaveApplicationDetails(String RequestID);

        [OperationContract]
        String validateStartDate(String startDate, String Year, String endDate, String PersonID);
        //LEAVE MANAGEMENT

        //PAYSLIP
        [OperationContract]
        String getCurrentMonthSlip(String PersonID, String period);

        [OperationContract]
        String getPayslipPeriod();
        //PAYSLIP

        //Administrator Functions
        [OperationContract]
        String loginAdmin(String essUser, String personID, String password);

        [OperationContract]
        String getmasterData();

        [OperationContract]
        String getSpecificmasterData(String masterDataID);

        [OperationContract]
        String updateSpecificMasterData(String dataObjID, String dataValue);

        [OperationContract]
        String getHolidays(String year);

        [OperationContract]
        String insertHoliday(int year, String holidayType ,String dayNmonth, String holidayName);

        [OperationContract]
        String deleteHoliday(String holidayName);

        [OperationContract]
        String updatePublicHoliday(String year);
        //Administrator Functions
      
        //GET LIST OF EMAIL TEMPLATES
        [OperationContract]
        String getEmailTemplates();

        [OperationContract]
        String getSpecificEmailTemplate(string emailID);

        [OperationContract]
        String updateSpecificEmailTemplate(string emailID, string emailContent, string emailSubject, string emailFooter);
        //GET LIST OF EMAIL TEMPLATES



        



        //REQUISITIONS
        [OperationContract]
        String makeRequisition(String items, int qty, String empID, String ApproverPersonID, String requestDate);

        [OperationContract]
        String getItemList();

        [OperationContract]
        String getPendingRequisitions(String PersonID);

        [OperationContract]
        String approveRequisition(String item, String qty, String dateRequested, String requisitionID, String requestersID, String comment, String approvalDate);

        [OperationContract]
        String getUserRequisitionHistory(String PersonID);
        //REQUISITIONS


        //recruitment
        [OperationContract]
        String getVacancies();
        //recruitment

        [OperationContract]
        String getCausesofAbsence(String empID);
    }
}

