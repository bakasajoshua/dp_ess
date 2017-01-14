using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;
using System.Data.SqlClient;
using System.Web.Script.Serialization;
using System.Data;
using System.Globalization;


namespace essDpService
{
    public class Myitems
    {
        public string itemName { get; set; }
        public int qty { get; set; }
    }

    public class Service : IService
    {
        //string connStr = "Data Source=VAPPDP001MI-001;Initial Catalog=essDp;User ID=ESSUser;Password=Akmakm123.;MultipleActiveResultSets=true;";
        string connStr = "Data Source=10.0.0.16,1433;Network Library=DBMSSOCN;Initial Catalog=essDp;User ID=ESSUser;Password=Akmakm123.;MultipleActiveResultSets=true;";
        String resp;
        JavaScriptSerializer serializer = new JavaScriptSerializer();

        public String registerUser(String essUser, String personID, String password, String firstTimeLoiginID)
        {
            string sqlStatement = "INSERT INTO ESSusers (EssUser, PersonID, Password,firstLogin) VALUES(@essUser,@personID,@pass,@firstTimeLoiginID)";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@essUser", essUser));
                    cmd.Parameters.Add(new SqlParameter("@personID", personID));
                    cmd.Parameters.Add(new SqlParameter("@pass", password));
                    cmd.Parameters.Add(new SqlParameter("@firstTimeLoiginID", firstTimeLoiginID));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Inserted";
                       // List<response> res = new List<response>{ new response{status = 0, msg = "Inserted"}};
                        //return serializer.Serialize(res.ToString());

                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }

        public String loginUser(String essUser, String personID, String password)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT NAVemployees.[PersonID] 
		                                ,[FirstName] 
		                                ,[MiddleName] 
		                                ,[LastName]
		                                ,[Email]
		                                ,[Nationality]
		                                ,[DOB]
		                                ,[Title]
		                                ,[Mobile]
		                                ,[Address]
		                                ,[LeaveGroupCode]
		                                ,[ApproversID]
                                        ,[FinalApproversID]
		                                ,[DateOfJoining]
		                                ,[status]
		                                ,NAVemployees.[picture] 
                                FROM [dbo].[NAVemployees] 
                                LEFT JOIN [dbo].[ESSusers] ON ESSusers.PersonID = NAVemployees.PersonID 
                                WHERE EssUser LIKE @EssUser AND ESSusers.PersonID LIKE  @personID AND ESSusers.Password LIKE @password";

            cmd.Parameters.AddWithValue("@EssUser", essUser);
            cmd.Parameters.AddWithValue("@personID", personID);
            cmd.Parameters.AddWithValue("@password", password);
            // string datas = "";
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                if (reader.Read())
                {
                    dt.Columns.Add("FirstName", typeof(string));
                    dt.Columns.Add("MiddleName", typeof(string));
                    dt.Columns.Add("LastName", typeof(string));
                    dt.Columns.Add("Email", typeof(string));
                    dt.Columns.Add("Nationality", typeof(string));
                    dt.Columns.Add("DOB", typeof(string));
                    dt.Columns.Add("Title", typeof(string));
                    dt.Columns.Add("Mobile", typeof(string));
                    dt.Columns.Add("Address", typeof(string));
                    dt.Columns.Add("LeaveGroupCode", typeof(string));
                    dt.Columns.Add("DateOfJoining", typeof(string));
                    dt.Columns.Add("ApproversID", typeof(string));
                    dt.Columns.Add("FinalApproversID", typeof(string));
                    dt.Columns.Add("Status", typeof(string));
                    dt.Columns.Add("Picture", typeof(string));


                    string FirstName = String.Format("{0}", reader["FirstName"]);
                    string MiddleName = String.Format("{0}", reader["MiddleName"]);
                    string LastName = String.Format("{0}", reader["LastName"]);
                    string Email = String.Format("{0}", reader["Email"]);
                    string Nationality = String.Format("{0}", reader["Nationality"]);
                    string DOB = String.Format("{0}", reader["DOB"]);
                    string status = String.Format("{0}", reader["status"]);
                    string Title = String.Format("{0}", reader["Title"]);
                    string Mobile = String.Format("{0}", reader["Mobile"]);
                    string Address = String.Format("{0}", reader["Address"]);
                    string LeaveGroupCode = String.Format("{0}", reader["LeaveGroupCode"]);
                    string DateOfJoining = String.Format("{0}", reader["DateOfJoining"]);
                    string ApproverPersonID = String.Format("{0}", reader["ApproversID"]);
                    string FinalApproversID = String.Format("{0}", reader["FinalApproversID"]);
                    string picture = String.Format("{0}", reader["Picture"]);

                    dt.Rows.Add(FirstName, MiddleName, LastName, Email, Nationality, DOB, Title, Mobile, Address, LeaveGroupCode, DateOfJoining, ApproverPersonID, FinalApproversID, status, picture);
                }
                else
                {
                    dt.Columns.Add("Error", typeof(string));
                    dt.Rows.Add("No Data Returned");
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);

            return newdt;
        }

        public string DataTableToJSONWithJavaScriptSerializer(DataTable table)
        {
            JavaScriptSerializer jsSerializer = new JavaScriptSerializer();
            List<Dictionary<string, object>> parentRow = new List<Dictionary<string, object>>();
            Dictionary<string, object> childRow;
            foreach (DataRow row in table.Rows)
            {
                childRow = new Dictionary<string, object>();
                foreach (DataColumn col in table.Columns)
                {
                    childRow.Add(col.ColumnName, row[col]);
                }
                parentRow.Add(childRow);
            }
            return jsSerializer.Serialize(parentRow);
        }

        public String checkUniqueUserNAV(String personID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = "SELECT * FROM NAVemployees WHERE PersonID LIKE @personID";
            cmd.Parameters.AddWithValue("@personID", personID);
            
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("Response", typeof(string));
                dt.Columns.Add("ResponseID", typeof(Int32));
                dt.Columns.Add("Email", typeof(string));
                dt.Columns.Add("FName", typeof(string));
                dt.Columns.Add("LName", typeof(string));
                if (reader.Read())
                {
                    string Email = String.Format("{0}", reader["Email"]);
                    string Fname = String.Format("{0}", reader["FirstName"]);
                    string Lname = String.Format("{0}", reader["LastName"]);
                    if (Email.Length == 0)
                    {
                        dt.Rows.Add("User exists as employee", 0, "email not available", "fname not available", "lname not available");
                    }
                    else
                    {
                        dt.Rows.Add("User exists as employee", 0, Email, Fname,Lname);
                    }
                }
                else
                {
                    dt.Rows.Add("User does not exists as employee",1,"email not available");
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);

            return newdt;
        }

        public String checkExistenceInESSDB(String personID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = "SELECT * FROM ESSusers WHERE PersonID LIKE @personID";
            cmd.Parameters.AddWithValue("@personID", personID);

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("Response", typeof(string));
                dt.Columns.Add("ResponseID", typeof(Int32));
                dt.Columns.Add("firstLogin", typeof(string));
                if (reader.Read())
                {
                    string firstLogin = String.Format("{0}", reader["firstLogin"]);
                    dt.Rows.Add("This ID exists as ESS user. Proceed to Login.", 0, firstLogin);
                }
                else
                {
                    dt.Rows.Add("This ID does not exist as ESS user",1, "not available");
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);

            return newdt;
        }

        //change
        public String getCausesofAbsence(String empID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();
 
            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT 
                                    PE.[adjustment]
                                    ,PE.[broughtForward]
                                    ,PE.[carriedForward]
                                    ,PE.[entitlementCode]
                                    ,PE.[TotalEntitlementForPayment]
                                    ,E.[Description]
                                FROM [dbo].[personalEntitlement] AS PE
                                LEFT JOIN [dbo].[ESSEntitlement] AS E
                                ON PE.[entitlementCode] LIKE E.[LeaveCode]
                                WHERE PE.[empID] LIKE @empID";
            cmd.Parameters.AddWithValue("@empID", empID);
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("entitlementCode", typeof(string));
                dt.Columns.Add("adjustment", typeof(string));
                dt.Columns.Add("broughtForward", typeof(string));
                dt.Columns.Add("carriedForward", typeof(string));
                dt.Columns.Add("TotalEntitlementForPayment", typeof(string));
                dt.Columns.Add("Description", typeof(string));
                    
                    while(reader.Read()){
                        string entitlementCode = String.Format("{0}", reader["entitlementCode"]);
                        string adjustment = String.Format("{0}", reader["adjustment"]);
                        string broughtForward = String.Format("{0}", reader["broughtForward"]);
                        string carriedForward = String.Format("{0}", reader["carriedForward"]);
                        string Description = String.Format("{0}", reader["Description"]);
                        string TotalEntitlementForPayment = String.Format("{0}", reader["TotalEntitlementForPayment"]);

                        dt.Rows.Add(entitlementCode, adjustment, broughtForward, carriedForward, TotalEntitlementForPayment, Description);
                    }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }
        //change

        public String submitLeaveRequest(String PersonID, String FromDate, String ToDate, String CauseOfAbsence, Int32 NoOfDays, String ApproversPersonID, String FinalApproversPersonID, String Year, String daysRemaining, String leaveGroupCode, String status, Int32 totalDaysApplied)
        {
            DateTime FDate = DateTime.ParseExact(FromDate, "yyyyMMdd", null);            
            DateTime TDate = DateTime.ParseExact(ToDate, "yyyyMMdd", null);
            //return "To Date"+TDate;
            string sqlStatement = @"INSERT INTO ESSleaverequest 
                                        (RequestID, 
                                        PersonID, 
                                        FromDate, 
                                        ToDate, 
                                        CauseOfAbsence, 
                                        Quantity, 
                                        Comment, 
                                        ApproversPersonID, 
                                        FinalApproversPersonID,
                                        DocumentNo, 
                                        status,
                                        leaveYear,
                                        syncStatus,
                                        workingDays) 
                                    VALUES
                                        (@RequestID
                                        ,@PersonID
                                        ,@FromDate
                                        ,@ToDate
                                        ,@CauseOfAbsence
                                        ,@NoOfDays
                                        ,''
                                        ,@ApproversPersonID
                                        ,@FinalApproversPersonID
                                        ,''
                                        ,@status
                                        ,@year
                                        ,'PENDING'
                                        ,@totalDaysApplied)";
            Int32 unixTimestamp = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String RequestID = unixTimestamp.ToString();

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@RequestID", RequestID));
                    cmd.Parameters.Add(new SqlParameter("@PersonID", PersonID));
                    cmd.Parameters.Add(new SqlParameter("@FromDate", FDate));
                    cmd.Parameters.Add(new SqlParameter("@ToDate", TDate));
                    cmd.Parameters.Add(new SqlParameter("@CauseOfAbsence", CauseOfAbsence));
                    cmd.Parameters.Add(new SqlParameter("@NoOfDays", NoOfDays));
                    cmd.Parameters.Add(new SqlParameter("@year", Year));
                    cmd.Parameters.Add(new SqlParameter("@ApproversPersonID", ApproversPersonID));
                    cmd.Parameters.Add(new SqlParameter("@FinalApproversPersonID", FinalApproversPersonID));
                    cmd.Parameters.Add(new SqlParameter("@status", status));
                    cmd.Parameters.Add(new SqlParameter("@totalDaysApplied", totalDaysApplied));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Inserted";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                    conn.Close();
                }
            }

            return resp;
        }


        public String getPendingRequests(String ApproversPersonID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();
            
            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT 
                                ELR.[ApproversPersonID]
                                ,ELR.RequestID
                                ,ELR.[CauseOfAbsence]
                                ,ELR.[Comment]
                                ,ELR.[DocumentNo]
                                ,ELR.[FromDate]
                                ,ELR.[ToDate]
                                ,ELR.[PersonID]
                                ,ELR.[Quantity]
                                ,ELR.[RequestID]
                                ,ELR.[status]	
	                            ,[ELR].[leaveYear]
                                ,[ELR].[FinalApproversPersonID]
	                            ,NE.FirstName
	                            ,NE.LastName
	                            ,NE.MiddleName
	                            ,NE.Title
	                            ,NE.Mobile
                                ,NE.PersonID
                                ,NE.Email
                            FROM [dbo].[ESSleaverequest] AS ELR
                            LEFT JOIN [dbo].[NAVemployees] AS NE
                            ON NE.[PersonID] = ELR.[PersonID]
                            WHERE (ELR.status = 'LEAVE RECEIVED' OR ELR.status = 'PENDING FINAL APPROVAL')  
							AND (ELR.ApproversPersonID = @ApproversPersonID OR ELR.FinalApproversPersonID = @ApproversPersonID) ";

//            cmd.CommandText = @"SELECT 
//                                ELR.[ApproversPersonID]
//                                ,ELR.RequestID
//                                ,ELR.[CauseOfAbsence]
//                                ,ELR.[Comment]
//                                ,ELR.[DocumentNo]
//                                ,ELR.[FromDate]
//                                ,ELR.[ToDate]
//                                ,ELR.[PersonID]
//                                ,ELR.[Quantity]
//                                ,ELR.[RequestID]
//                                ,ELR.[status]	
//	                            ,[ELR].[leaveYear]
//	                            ,NE.FirstName
//	                            ,NE.LastName
//	                            ,NE.MiddleName
//	                            ,NE.Title
//	                            ,NE.Mobile
//                                ,NE.PersonID
//                                ,NE.Email
//                            FROM [dbo].[ESSleaverequest] AS ELR
//                            LEFT JOIN [dbo].[NAVemployees] AS NE
//                            ON NE.[PersonID] = ELR.[PersonID]
//                            WHERE ELR.status = 'PENDING APPROVAL' AND ELR.ApproversPersonID = @ApproversPersonID
//                            ";

            cmd.Parameters.AddWithValue("@ApproversPersonID", ApproversPersonID);
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("ApplicantsPersonID", typeof(string));
                dt.Columns.Add("ApproversID", typeof(string));
                dt.Columns.Add("FinalApproversID", typeof(string));
                dt.Columns.Add("RequestID", typeof(string));
                dt.Columns.Add("FromDate", typeof(string));
                dt.Columns.Add("ToDate", typeof(string));
                dt.Columns.Add("AbsenceCode", typeof(string));
                //dt.Columns.Add("AbsenceDescription", typeof(string));
                //dt.Columns.Add("AbsentDaysEntitlement", typeof(string));
                dt.Columns.Add("AbsentDaysApplied", typeof(string));
                dt.Columns.Add("Comment", typeof(string));
                dt.Columns.Add("status", typeof(string));
                dt.Columns.Add("FirstName", typeof(string));
                dt.Columns.Add("MiddleName", typeof(string));
                dt.Columns.Add("LastName", typeof(string));
                dt.Columns.Add("Email", typeof(string));
                dt.Columns.Add("Title", typeof(string));
                dt.Columns.Add("Mobile", typeof(string));
                    
                    while(reader.Read()){
                        string ApplicantsPersonID = String.Format("{0}", reader["PersonID"]);
                        string AppPersonID = String.Format("{0}", reader["ApproversPersonID"]);
                        string FinalApproversPersonID = String.Format("{0}", reader["FinalApproversPersonID"]);
                        string RequestID = String.Format("{0}", reader["RequestID"]);
                        string FromDate = String.Format("{0}", reader["FromDate"]);
                        string ToDate = String.Format("{0}", reader["ToDate"]);
                        string AbsenceCode = String.Format("{0}", reader["CauseOfAbsence"]);
                        //string AbsenceDescription = String.Format("{0}", reader["AbsenceDescription"]);
                        //string AbsentDaysEntitlement = String.Format("{0}", reader["AbsentDaysEntitlement"]);
                        string AbsentDaysApplied = String.Format("{0}", reader["Quantity"]);
                        string Comment = String.Format("{0}", reader["Comment"]);
                        string status = String.Format("{0}", reader["status"]);
                        string FirstName = String.Format("{0}", reader["FirstName"]);
                        string MiddleName = String.Format("{0}", reader["MiddleName"]);
                        string LastName = String.Format("{0}", reader["LastName"]);
                        string Email = String.Format("{0}", reader["Email"]);
                        string Title = String.Format("{0}", reader["Title"]);
                        string Mobile = String.Format("{0}", reader["Mobile"]);

                        dt.Rows.Add(ApplicantsPersonID, AppPersonID, FinalApproversPersonID, RequestID, FromDate, ToDate, AbsenceCode, AbsentDaysApplied, Comment, status, FirstName, MiddleName, LastName, Email, Title, Mobile);
                        
                    }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String approveRequest(String RequestID, String comment, String status)
        {
            string sqlStatement = "UPDATE ESSleaverequest SET status = @status, Comment = @comment Where [ESSleaverequest].[RequestID] = @RequestID";
            
            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@RequestID", RequestID));
                    cmd.Parameters.Add(new SqlParameter("@comment", comment));
                    cmd.Parameters.Add(new SqlParameter("@status", status));
                   
                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                        
                        // List<response> res = new List<response>{ new response{status = 0, msg = "Inserted"}};
                        //return serializer.Serialize(res.ToString());
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }

        public String getUserLeaveApplication(String PersonID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT 
                                NE.[FirstName]
                                ,NE.[LastName]
                                ,NE.[MiddleName]
                                ,NE.[Mobile]
                                ,NE.[Title]
                                ,ELR.[ApproversPersonID]
                                ,ELR.[CauseOfAbsence] AS AbsenceCode
                                ,EPE.[entitlementDescription] AS AbsenceReason
                                ,EPE.[totalEntitlementForPayment] AS DaysEntitled
                                ,ELR.[Comment]
                                ,ELR.[DocumentNo]
                                ,ELR.[FromDate]
                                ,ELR.[ToDate]
                                ,ELR.[PersonID]
                                ,ELR.[Quantity] AS DaysApplied
                                ,ELR.[RequestID]
                                ,ELR.[status]	
                                FROM [dbo].[ESSleaverequest] AS ELR
                                LEFT JOIN [dbo].ESSPersonalEntitlement AS EPE
                                ON EPE.[entitlementCode] = ELR.CauseOfAbsence AND empID = @PersonID
                                LEFT JOIN NAVemployees AS NE
                                ON NE.[PersonID] = ELR.[PersonID]
                                WHERE ELR.[PersonID] LIKE @PersonID
                                ORDER BY status
                            ";

            cmd.Parameters.AddWithValue("@PersonID", PersonID);
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("ApplicantsPersonID", typeof(string));
                dt.Columns.Add("RequestID", typeof(string));
                dt.Columns.Add("FromDate", typeof(string));
                dt.Columns.Add("ToDate", typeof(string));
                dt.Columns.Add("AbsenceCode", typeof(string));
                dt.Columns.Add("AbsenceDescription", typeof(string));
                dt.Columns.Add("AbsentDaysEntitlement", typeof(string));
                dt.Columns.Add("AbsentDaysApplied", typeof(string));
                dt.Columns.Add("Comment", typeof(string));
                dt.Columns.Add("status", typeof(string));
                

                while (reader.Read())
                {
                    string ApplicantsPersonID = String.Format("{0}", reader["PersonID"]);
                    string RequestID = String.Format("{0}", reader["RequestID"]);
                    string FromDate = String.Format("{0}", reader["FromDate"]);
                    string ToDate = String.Format("{0}", reader["ToDate"]);
                    string AbsenceCode = String.Format("{0}", reader["AbsenceCode"]);
                    string AbsenceDescription = String.Format("{0}", reader["AbsenceReason"]);
                    string AbsentDaysEntitlement = String.Format("{0}", reader["DaysEntitled"]);
                    string AbsentDaysApplied = String.Format("{0}", reader["DaysApplied"]);
                    string Comment = String.Format("{0}", reader["Comment"]);
                    string status = String.Format("{0}", reader["status"]);
                   

                    dt.Rows.Add(ApplicantsPersonID, RequestID, FromDate, ToDate, AbsenceCode, AbsenceDescription, AbsentDaysEntitlement, AbsentDaysApplied, Comment, status);

                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getLeaveApplicationDetails(String RequestID){
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();
            
            conn.Open();
            cmd.Connection = conn;
          
            cmd.CommandText = @"SELECT [RequestID]
                                  ,[PersonID]
                                  ,[FromDate]
                                  ,[ToDate]
                                  ,[CauseOfAbsence]
                                  ,[Quantity]
                                  ,[Comment]
                                  ,[ApproversPersonID]
                                  ,[DocumentNo]
                                  ,[status]
                                  ,[leaveYear]
                                  ,[syncStatus]
                              FROM [dbo].[ESSleaverequest]
                              WHERE RequestID = @RequestID
                            ";

            cmd.Parameters.AddWithValue("@RequestID", RequestID);
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("PersonID", typeof(string));
                dt.Columns.Add("RequestID", typeof(string));
                dt.Columns.Add("CauseOfAbsence", typeof(string));

                dt.Columns.Add("FromDate", typeof(string));
                dt.Columns.Add("ToDate", typeof(string));
                dt.Columns.Add("AbsenceCode", typeof(string));
                //dt.Columns.Add("AbsenceDescription", typeof(string));
                //dt.Columns.Add("AbsentDaysEntitlement", typeof(string));
                dt.Columns.Add("AbsentDaysApplied", typeof(string));
                dt.Columns.Add("Comment", typeof(string));
                dt.Columns.Add("status", typeof(string));
                //dt.Columns.Add("FirstName", typeof(string));
                //dt.Columns.Add("MiddleName", typeof(string));
                //dt.Columns.Add("LastName", typeof(string));
                //dt.Columns.Add("Email", typeof(string));
                //dt.Columns.Add("Title", typeof(string));
                //dt.Columns.Add("Mobile", typeof(string));
                    
                    while(reader.Read()){
                        string ApplicantsPersonID = String.Format("{0}", reader["PersonID"]);
                        string RQID = String.Format("{0}", reader["RequestID"]);
                        string FromDate = String.Format("{0}", reader["FromDate"]);
                        string ToDate = String.Format("{0}", reader["ToDate"]);
                        string AbsenceCode = String.Format("{0}", reader["CauseOfAbsence"]);
                        //string AbsenceDescription = String.Format("{0}", reader["AbsenceDescription"]);
                        //string AbsentDaysEntitlement = String.Format("{0}", reader["AbsentDaysEntitlement"]);
                        string AbsentDaysApplied = String.Format("{0}", reader["Quantity"]);
                        string Comment = String.Format("{0}", reader["Comment"]);
                        string status = String.Format("{0}", reader["status"]);
                        //string FirstName = String.Format("{0}", reader["FirstName"]);
                        //string MiddleName = String.Format("{0}", reader["MiddleName"]);
                        //string LastName = String.Format("{0}", reader["LastName"]);
                        //string Email = String.Format("{0}", reader["Email"]);
                        //string Title = String.Format("{0}", reader["Title"]);
                        //string Mobile = String.Format("{0}", reader["Mobile"]);

                        dt.Rows.Add(ApplicantsPersonID, RQID, AbsenceCode, FromDate, ToDate, AbsenceCode, AbsentDaysApplied, Comment, status);
                        
                    }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getCurrentMonthSlip(String PersonID, String period)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();
            DataTable dt2 = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT [Payslip Set]
                                  ,[Line No]
                                  ,[Employee1]
                                  ,[Period Name1]
                                  ,[Description1]
                                  ,[Amount1]
                                  ,[Period]
                                  ,[Title1]
                                  ,[Department1]
                                  ,[EmpBranch1]
                                  ,[Bank1]
                                  ,[Branch1]
                                  ,[Account1]
                                  ,[PIN1]
                                  ,[NHIF1]
                                  ,[NSSF1]
                                  ,[Qty1]
                                  ,[Rate1]
                                  ,[Cumm1]
                                  ,[Bal1]
                                  ,[NetPay1]
                                  ,[Payroll Code]
                              FROM  [dbo].[Payslips]
                              WHERE Employee1 LIKE @PersonID
                              AND Period LIKE @period
                              ORDER BY [Payslip Set],[Line No]";

            cmd.Parameters.AddWithValue("@PersonID", PersonID);
            cmd.Parameters.AddWithValue("@period", period);
            

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("Payslip Set", typeof(string));
                dt.Columns.Add("Line No", typeof(string));
                dt.Columns.Add("Employee1", typeof(string));
                dt.Columns.Add("Period Name1", typeof(string));
                dt.Columns.Add("Description1", typeof(string));
                dt.Columns.Add("Amount1", typeof(string));
                dt.Columns.Add("Period", typeof(string));
                dt.Columns.Add("Title1", typeof(string));
                dt.Columns.Add("Department1", typeof(string));
                dt.Columns.Add("EmpBranch1", typeof(string));
                dt.Columns.Add("Bank1", typeof(string));
                dt.Columns.Add("Branch1", typeof(string));
                dt.Columns.Add("Account1", typeof(string));
                dt.Columns.Add("PIN1", typeof(string));
                dt.Columns.Add("NHIF1", typeof(string));
                dt.Columns.Add("NSSF1", typeof(string));
                dt.Columns.Add("Qty1", typeof(string));
                dt.Columns.Add("Rate1", typeof(string));
                dt.Columns.Add("Cumm1", typeof(string));
                dt.Columns.Add("Bal1", typeof(string));
                dt.Columns.Add("NetPay1", typeof(string));
                dt.Columns.Add("Payroll Code", typeof(string));

                if (reader.HasRows)
                {
                    while (reader.Read())
                    {
                        string PayslipSet = String.Format("{0}", reader["Payslip Set"]);
                        string LineNo = String.Format("{0}", reader["Line No"]);
                        string Employee1 = String.Format("{0}", reader["Employee1"]);
                        string PeriodName1 = String.Format("{0}", reader["Period Name1"]);
                        string Description1 = String.Format("{0}", reader["Description1"]);
                        string Amount1 = String.Format("{0}", reader["Amount1"]);
                        string Period = String.Format("{0}", reader["Period"]);
                        string Title1 = String.Format("{0}", reader["Title1"]);
                        string Department1 = String.Format("{0}", reader["Department1"]);
                        string EmpBranch1 = String.Format("{0}", reader["EmpBranch1"]);
                        string Bank1 = String.Format("{0}", reader["Bank1"]);
                        string Branch1 = String.Format("{0}", reader["Branch1"]);
                        string Account1 = String.Format("{0}", reader["Account1"]);
                        string PIN1 = String.Format("{0}", reader["PIN1"]);
                        string NHIF1 = String.Format("{0}", reader["NHIF1"]);
                        string NSSF1 = String.Format("{0}", reader["NSSF1"]);
                        string Qty1 = String.Format("{0}", reader["Qty1"]);
                        string Rate1 = String.Format("{0}", reader["Rate1"]);
                        string Cumm1 = String.Format("{0}", reader["Cumm1"]);
                        string Bal1 = String.Format("{0}", reader["Bal1"]);
                        string NetPay1 = String.Format("{0}", reader["NetPay1"]);
                        string PayrollCode = String.Format("{0}", reader["Payroll Code"]);

                        //dt.Rows.Add(PayslipSet, LineNo, Employee1, PeriodName1, Description1, Amount1, Period, Title1, Department1, EmpBranch1, Bank1, Branch1, Account1, PIN1, NHIF1, NSSF1, Qty1, Rate1, Cumm1, Bal1, NetPay1);
                        dt.Rows.Add(PayslipSet, LineNo, Employee1, PeriodName1, Description1, Amount1, Period, Title1, Department1, EmpBranch1, Bank1, Branch1, Account1, PIN1, NHIF1, NSSF1, Qty1, Rate1, Cumm1, Bal1, NetPay1, PayrollCode);
                    }
                }
                else
                {
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String denyApproval(String RequestID, String Comment)
        {
            string sqlStatement = "UPDATE ESSleaverequest SET status = 'REJECTED', Comment = @Comment  Where [ESSleaverequest].[RequestID] = @RequestID";
            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@RequestID", RequestID));
                    cmd.Parameters.Add(new SqlParameter("@Comment", Comment));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                        // List<response> res = new List<response>{ new response{status = 0, msg = "Inserted"}};
                        //return serializer.Serialize(res.ToString());
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }

        public String getPayslipPeriod()
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();
            conn.Open();
            cmd.Connection = conn;

            cmd.CommandText = @"SELECT Period FROM dbo.Payslips GROUP BY Period ORDER BY Period";
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("Period", typeof(string));
                while (reader.Read())
                {
                    string ApplicantsPersonID = String.Format("{0}", reader["Period"]);
                    dt.Rows.Add(ApplicantsPersonID);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String saveTempPass(String PersonID, String tempPass)
        {
            string sqlStatement = "UPDATE ESSusers SET [tempPass] = @tempPass WHERE [PersonID] = @PersonID";
            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@tempPass", tempPass));
                    cmd.Parameters.Add(new SqlParameter("@PersonID", PersonID));
                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Inserted";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }

        public String checkPasswordChange(String PersonID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT [tempPass] FROM [dbo].[ESSusers] WHERE PersonID = @PersonID";
            cmd.Parameters.AddWithValue("@PersonID", PersonID);



            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("tempPass", typeof(string));
                while (reader.Read())
                {
                    string tempPass = String.Format("{0}", reader["tempPass"]);
                    dt.Rows.Add(tempPass);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String checkResetPassword(String empNo, String resetCode)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT * FROM [dbo].[ESSusers] WHERE PersonID = @PersonID AND tempPass = @tempass";
            cmd.Parameters.AddWithValue("@PersonID", empNo);
            cmd.Parameters.AddWithValue("@tempass", resetCode);

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("status", typeof(string));
                //while (reader.Read())
                //{
                //    //string tempPass = String.Format("{0}", reader["tempPass"]);
                //    dt.Rows.Add("");
                //}

                if (reader.Read())
                {
                    dt.Rows.Add("Match found");
                }else{
                    dt.Rows.Add("Match not found");
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String updateNewPassword(String empNo, String newpass)
        {
            string sqlStatement = "UPDATE ESSusers SET [tempPass] = NULL, Password = @newpass WHERE [PersonID] = @empNo";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@newpass", newpass));
                    cmd.Parameters.Add(new SqlParameter("@empNo", empNo));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }

        public String firstTimeLoginCheck(String PersonID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT [firstLogin] FROM [dbo].[ESSusers] WHERE PersonID = @PersonID";
            cmd.Parameters.AddWithValue("@PersonID", PersonID);

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("firstLogin", typeof(string));
                while (reader.Read())
                {
                    string tempPass = String.Format("{0}", reader["firstLogin"]);
                    dt.Rows.Add(tempPass);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String ftloginUser(String essUser, String personID, String password, String ftloginCode)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            //cmd.CommandText = "SELECT * FROM EssUsers WHERE EssUser LIKE  @EssUser AND PersonID LIKE @personID AND Password LIKE @password";
            cmd.CommandText = @"SELECT NAVemployees.[PersonID] 
	                                ,[FirstName] 
	                                ,[MiddleName] 
	                                ,[LastName]
	                                ,[Email]
	                                ,[Nationality]
	                                ,[DOB]
	                                ,[Title]
	                                ,[Mobile]
	                                ,[Address]
	                                ,[LeaveGroupCode]
	                                ,[ApproversID]
                                    ,[FinalApproversID]
	                                ,[DateOfJoining]
                                    ,[status]
                                FROM [dbo].[NAVemployees] 
                                LEFT JOIN [dbo].[ESSusers] 
                                ON ESSusers.PersonID = NAVemployees.PersonID
                                WHERE EssUser LIKE @EssUser AND ESSusers.PersonID LIKE  @personID AND ESSusers.Password LIKE @password";

            cmd.Parameters.AddWithValue("@EssUser", essUser);
            cmd.Parameters.AddWithValue("@personID", personID);
            cmd.Parameters.AddWithValue("@password", password);
            // string datas = "";
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                if (reader.Read())
                {
                    dt.Columns.Add("FirstName", typeof(string));
                    dt.Columns.Add("MiddleName", typeof(string));
                    dt.Columns.Add("LastName", typeof(string));
                    dt.Columns.Add("Email", typeof(string));
                    dt.Columns.Add("Nationality", typeof(string));
                    dt.Columns.Add("DOB", typeof(string));
                    dt.Columns.Add("Title", typeof(string));
                    dt.Columns.Add("Mobile", typeof(string));
                    dt.Columns.Add("Address", typeof(string));
                    dt.Columns.Add("LeaveGroupCode", typeof(string));
                    dt.Columns.Add("ApproversID", typeof(string));
                    dt.Columns.Add("FinalApproversID", typeof(string));
                    dt.Columns.Add("DateOfJoining", typeof(string));
                    dt.Columns.Add("status", typeof(string));

                    string FirstName = String.Format("{0}", reader["FirstName"]);
                    string MiddleName = String.Format("{0}", reader["MiddleName"]);
                    string LastName = String.Format("{0}", reader["LastName"]);
                    string Email = String.Format("{0}", reader["Email"]);
                    string Nationality = String.Format("{0}", reader["Nationality"]);
                    string DOB = String.Format("{0}", reader["DOB"]);
                    string status = String.Format("{0}", reader["status"]);
                    string Title = String.Format("{0}", reader["Title"]);
                    string Mobile = String.Format("{0}", reader["Mobile"]);
                    string Address = String.Format("{0}", reader["Address"]);
                    string ApproversID = String.Format("{0}", reader["ApproversID"]);
                    string FinalApproversID = String.Format("{0}", reader["FinalApproversID"]);
                    string LeaveGroupCode = String.Format("{0}", reader["LeaveGroupCode"]);
                    string DateOfJoining = String.Format("{0}", reader["DateOfJoining"]);

                    dt.Rows.Add(FirstName, MiddleName, LastName, Email, Nationality, DOB, Title, Mobile, Address, LeaveGroupCode, ApproversID, FinalApproversID, DateOfJoining, status);

                    updateFirstTimeLogin(personID);
                }
                else
                {
                    dt.Columns.Add("Error", typeof(string));
                    dt.Rows.Add("No Data Returned");
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);

            return newdt;
        }

        public void updateFirstTimeLogin(String personID)
        {
            string sqlStatement = "UPDATE ESSusers SET [firstLogin] = NULL WHERE [PersonID] = @personID";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@personID", personID));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
        }

        public String makeRequisition(String items, int qty, String empID, String ApproverPersonID, String requestDate)
        {
            String itName = null;
            int itQty = 0;
            string jsonString = items;
            List<Myitems> itemsRequseted = (List<Myitems>)serializer.Deserialize(jsonString, typeof(List<Myitems>));
            Int32 unixTimestamp = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            String RequisitionID = unixTimestamp.ToString();

            foreach (Myitems item in itemsRequseted)
            {
                itName = item.itemName;
                itQty = item.qty;
                
                string sqlStatement = "INSERT INTO requisitions (requisitionID, item, qty, empID,escalationlvl1,escalationlvl2,escalationlvl3,requestdate) VALUES(@requisitionID, @item,@qty,@empID,@escalationlvl1,@escalationlvl2,@escalationlvl3,@requestdate)";
                using (SqlConnection conn = new SqlConnection(connStr))
                {
                    using (SqlCommand cmd = new SqlCommand())
                    {
                        cmd.Connection = conn;
                        cmd.CommandText = sqlStatement;

                        cmd.Parameters.Add(new SqlParameter("@requisitionID", RequisitionID));
                        cmd.Parameters.Add(new SqlParameter("@item", itName));
                        cmd.Parameters.Add(new SqlParameter("@qty", itQty));
                        cmd.Parameters.Add(new SqlParameter("@empID", empID));
                        cmd.Parameters.Add(new SqlParameter("@escalationlvl1", ApproverPersonID));
                        cmd.Parameters.Add(new SqlParameter("@escalationlvl2", '0'));
                        cmd.Parameters.Add(new SqlParameter("@escalationlvl3", '0'));
                        cmd.Parameters.Add(new SqlParameter("@requestdate", requestDate));

                        try
                        {
                            conn.Open();
                            cmd.ExecuteNonQuery();
                            resp = "Inserted";
                            // List<response> res = new List<response>{ new response{status = 0, msg = "Inserted"}};
                            //return serializer.Serialize(res.ToString());
                        }
                        catch (SqlException e)
                        {
                            resp = e.ToString();
                        }
                    }
                }
            }
            return resp;
        }

        public String getVacancies()
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"
                SELECT [timestamp]
                      ,[RecruitmentNumber]
                      ,[PostNumber]
                      ,[Created]
                      ,[LastUpdated]
                      ,[UpdatedBy]
                      ,[OrganisationCodeNo]
                      ,[ManagerGroupCode]
                      ,[AdminGroupCode]
                      ,[VacancyLetter]
                      ,[VacancyAdvertisingCode1]
                      ,[VacancyAdvertisingCost1]
                      ,[VacancyAdvertisingCode2]
                      ,[VacancyAdvertisingCost2]
                      ,[VacancyAdvertisingCode3]
                      ,[VacancyAdvertisingCost3]
                      ,[VacancyAdvertisingCode4]
                      ,[VacancyAdvertisingCost4]
                      ,[VacancyAdvertisingCode5]
                      ,[VacancyAdvertisingCost5]
                      ,[VacancyAdvertisingCode6]
                      ,[VacancyAdvertisingCost6]
                      ,[FullTimeVacCount]
                      ,[PartTimeVacCount]
                      ,[ApplicationDeadline]
                      ,[Stage]
                      ,[JobDescription]
                      ,[CurrentAdvertisement]
                      ,[Global Dimension 1 Code]
                      ,[LocationCode]
                      ,[EndDate]
                      ,[Complete]
                      ,[Global Dimension 2 Code]
                      ,[RecordID]
                      ,[ManagerResponsible]
                      ,[HRResponsible]
                      ,[ProcessStart]
                      ,[ProcessEnd]
                      ,[AdvertisingFilterCheck]
                  FROM [KIPPRA-LIVE].[dbo].[KIPPRA$HRRecruitment]";

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("PostNumber", typeof(string));
                while (reader.Read())
                {
                    string tempPass = String.Format("{0}", reader["PostNumber"]);
                    dt.Rows.Add(tempPass);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getItemList()
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT TOP 1000 [Description]
                                ,[Base Unit of Measure]
                                FROM [dbo].[ESSitems]";

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("Description", typeof(string));
                dt.Columns.Add("unitOMeasure", typeof(string));
                while (reader.Read())
                {
                    string Description = String.Format("{0}", reader["Description"]);
                    string unitOMeasure = String.Format("{0}", reader["Base Unit of Measure"]);
                    dt.Rows.Add(Description, unitOMeasure);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getPendingRequisitions(String PersonID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT [id]
                                  ,req.[requisitionID]
                                  ,req.[item]
                                  ,req.[qty]
                                  ,req.[empID]
                                  ,req.[escalationlvl1]
                                  ,req.[escalationlvl2]
                                  ,req.[escalationlvl3]
                                  ,req.[requestdate]
	                              ,NAVEmp.[FirstName]
	                              ,NAVEmp.[MiddleName]
	                              ,NAVEmp.[LastName]
	                              ,NAVEmp.[Title]
	                              
                              FROM [dbo].[requisitions] AS req
                              LEFT JOIN [dbo].[NAVemployees] AS NAVEmp
                              ON req.empID = NAVEmp.PersonID
                              WHERE escalationlvl1 = @PersonID
                              AND req.status IS NULL";


            cmd.Parameters.AddWithValue("@PersonID", PersonID);
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("RequisitionID", typeof(string));
                dt.Columns.Add("ItemName", typeof(string));
                dt.Columns.Add("Qty", typeof(string));
                dt.Columns.Add("EmployeeID", typeof(string));
                dt.Columns.Add("FName", typeof(string));
                dt.Columns.Add("MName", typeof(string));
                dt.Columns.Add("LName", typeof(string));
                dt.Columns.Add("Title", typeof(string));
                dt.Columns.Add("RequestDate", typeof(string));

                while (reader.Read())
                {
                    string RequisitionID = String.Format("{0}", reader["requisitionID"]);
                    string ItemName = String.Format("{0}", reader["item"]);
                    string Qty = String.Format("{0}", reader["qty"]);
                    string EmployeeID = String.Format("{0}", reader["empID"]);
                    string FName = String.Format("{0}", reader["FirstName"]);
                    string MName = String.Format("{0}", reader["MiddleName"]);
                    string LName = String.Format("{0}", reader["LastName"]);
                    string Title = String.Format("{0}", reader["Title"]);
                    string RequestDate = String.Format("{0}", reader["requestdate"]);

                    dt.Rows.Add(RequisitionID, ItemName, Qty, EmployeeID, FName, MName, LName, Title, RequestDate);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String approveRequisition(String item, String qty, String dateRequested, String requisitionID, String requestersID, String comment, String approvalDate){
            String sqlStatement = @"UPDATE [dbo].[requisitions]
                                   SET 
                                      [comment] = @comment
                                      ,[status] = 'APPROVED'
                                      ,[approvalDate] = @approvalDate
                                 WHERE requisitionID = @requisitionID
                                 AND item LIKE @item
                                 AND qty = @qty
                                 AND requestDate = @requestdate
                                 AND empID  = @requestersID";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@comment", comment));
                    cmd.Parameters.Add(new SqlParameter("@approvalDate", approvalDate));
                    cmd.Parameters.Add(new SqlParameter("@requisitionID", requisitionID));
                    cmd.Parameters.Add(new SqlParameter("@item", item));
                    cmd.Parameters.Add(new SqlParameter("@qty", qty));
                    cmd.Parameters.Add(new SqlParameter("@requestdate", dateRequested));
                    cmd.Parameters.Add(new SqlParameter("@requestersID", requestersID));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }

        public String getUserRequisitionHistory(String PersonID){
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT TOP 10 [id]
                                  ,[requisitionID]
                                  ,[item]
                                  ,[qty]
                                  ,[empID]
                                  ,[escalationlvl1]
                                  ,[escalationlvl2]
                                  ,[escalationlvl3]
                                  ,[requestdate]
                                  ,[comment]
                                  ,[status]
                                  ,[approvalDate]
                              FROM [dbo].[requisitions]
                              WHERE empID = @PersonID";

            cmd.Parameters.AddWithValue("@PersonID", PersonID);
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("requisitionID", typeof(string));
                dt.Columns.Add("item", typeof(string));
                dt.Columns.Add("qty", typeof(string));
                dt.Columns.Add("empID", typeof(string));
                dt.Columns.Add("escalationlvl1", typeof(string));
                dt.Columns.Add("escalationlvl2", typeof(string));
                dt.Columns.Add("escalationlvl3", typeof(string));
                dt.Columns.Add("requestdate", typeof(string));
                dt.Columns.Add("comment", typeof(string));
                dt.Columns.Add("status", typeof(string));
                dt.Columns.Add("approvalDate", typeof(string));


                while (reader.Read())
                {
                    string requisitionID = String.Format("{0}", reader["requisitionID"]);
                    string item = String.Format("{0}", reader["item"]);
                    string qty = String.Format("{0}", reader["qty"]);
                    string empID = String.Format("{0}", reader["empID"]);
                    string escalationlvl1 = String.Format("{0}", reader["escalationlvl1"]);
                    string escalationlvl2 = String.Format("{0}", reader["escalationlvl2"]);
                    string escalationlvl3 = String.Format("{0}", reader["escalationlvl3"]);
                    string requestdate = String.Format("{0}", reader["requestdate"]);
                    string comment = String.Format("{0}", reader["comment"]);
                    string status = String.Format("{0}", reader["status"]);
                    string approvalDate = String.Format("{0}", reader["approvalDate"]);

                    dt.Rows.Add(requisitionID, item, qty, empID, escalationlvl1, escalationlvl2, escalationlvl3, requestdate, comment, status, approvalDate);

                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getEmailTemplates(){
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT [emailID]
                                  ,[pageUsedAt]
                                  ,[subject]
                                  ,[emailContent]
                                  ,[emailFooter]
                                  ,[reasonForSending]
                              FROM [dbo].[ESSSystemEmail]";

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("emailID", typeof(string));
                dt.Columns.Add("pageUsedAt", typeof(string));
                dt.Columns.Add("subject", typeof(string));
                dt.Columns.Add("emailContent", typeof(string));
                dt.Columns.Add("emailFooter", typeof(string));
                dt.Columns.Add("reasonForSending", typeof(string));
                
                while (reader.Read())
                {
                    string emailID = String.Format("{0}", reader["emailID"]);
                    string pageUsedAt = String.Format("{0}", reader["pageUsedAt"]);
                    string subject = String.Format("{0}", reader["subject"]);
                    string emailContent = String.Format("{0}", reader["emailContent"]);
                    string emailFooter = String.Format("{0}", reader["emailFooter"]);
                    string reasonForSending = String.Format("{0}", reader["reasonForSending"]);

                    dt.Rows.Add(emailID, pageUsedAt, subject, emailContent, emailFooter, reasonForSending);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getSpecificEmailTemplate(string emailID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT [emailID]
                                  ,[pageUsedAt]
                                  ,[subject]
                                  ,[emailContent]
                                  ,[emailFooter]
                                  ,[reasonForSending]
                              FROM [dbo].[ESSSystemEmail]
                              WHERE [emailID] LIKE @emailID";
            cmd.Parameters.AddWithValue("@emailID", emailID);

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("emailID", typeof(string));
                dt.Columns.Add("pageUsedAt", typeof(string));
                dt.Columns.Add("subject", typeof(string));
                dt.Columns.Add("emailContent", typeof(string));
                dt.Columns.Add("emailFooter", typeof(string));
                dt.Columns.Add("reasonForSending", typeof(string));

                while (reader.Read())
                {
                    string EmailID = String.Format("{0}", reader["emailID"]);
                    string pageUsedAt = String.Format("{0}", reader["pageUsedAt"]);
                    string subject = String.Format("{0}", reader["subject"]);
                    string emailContent = String.Format("{0}", reader["emailContent"]);
                    string emailFooter = String.Format("{0}", reader["emailFooter"]);
                    string reasonForSending = String.Format("{0}", reader["reasonForSending"]);

                    dt.Rows.Add(EmailID, pageUsedAt, subject, emailContent, emailFooter, reasonForSending);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String updateSpecificEmailTemplate(string emailID, string emailContent, string emailSubject, string emailFooter)
        {
            string sqlStatement = null;

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    sqlStatement = @"UPDATE [dbo].[ESSSystemEmail] 
                                SET [subject] = @emailSubject,
                                [emailContent] = @emailContent,
                                [emailFooter] = @emailFooter
                                WHERE [emailID] LIKE @emailID";
                    cmd.Parameters.Add(new SqlParameter("@emailContent", emailContent));
                    cmd.Parameters.Add(new SqlParameter("@emailSubject", emailSubject));
                    cmd.Parameters.Add(new SqlParameter("@emailFooter", emailFooter));
                    cmd.Parameters.Add(new SqlParameter("@emailID", emailID));



                    cmd.CommandText = sqlStatement;
                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
                conn.Close();
            }
            return resp;
        }

        public String loginAdmin(String essUser, String personID, String password)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT NAVemployees.[PersonID] 
		                                ,[FirstName] 
		                                ,[MiddleName] 
		                                ,[LastName]
		                                ,[Email]
		                                ,[Nationality]
		                                ,[DOB]
		                                ,[Title]
		                                ,[Mobile]
		                                ,[Address]
		                                ,[LeaveGroupCode]
		                                ,[DateOfJoining]
		                                ,NAVemployees.[picture] 
		                                ,[dbo].[accessGranted].accessCode
		                                ,accessLevel.accessLevel
                                FROM [dbo].[NAVemployees] 
                                LEFT JOIN [dbo].[ESSusers] 
                                ON ESSusers.PersonID = NAVemployees.PersonID  
                                LEFT JOIN [dbo].[accessGranted]
                                ON [dbo].[accessGranted].empID LIKE NAVemployees.PersonID 
                                LEFT JOIN accessLevel 
                                ON [dbo].[accessGranted].accessCode LIKE accessLevel.accessCode
                                WHERE EssUser LIKE @EssUser AND ESSusers.PersonID LIKE @personID  AND ESSusers.Password LIKE @password";

            cmd.Parameters.AddWithValue("@EssUser", essUser);
            cmd.Parameters.AddWithValue("@personID", personID);
            cmd.Parameters.AddWithValue("@password", password);
           // string datas = "";
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                if (reader.Read())
                {
                    dt.Columns.Add("FirstName", typeof(string));
                    dt.Columns.Add("MiddleName", typeof(string));
                    dt.Columns.Add("LastName", typeof(string));
                    dt.Columns.Add("Email", typeof(string));
                    dt.Columns.Add("Nationality", typeof(string));
                    dt.Columns.Add("DOB", typeof(string));
                    dt.Columns.Add("Title", typeof(string));
                    dt.Columns.Add("Mobile", typeof(string));
                    dt.Columns.Add("Address", typeof(string));
                    dt.Columns.Add("LeaveGroupCode", typeof(string));
                    dt.Columns.Add("DateOfJoining", typeof(string));
                    dt.Columns.Add("Picture", typeof(string));
                    dt.Columns.Add("accessCode", typeof(string));
                    dt.Columns.Add("accessLevel", typeof(string));

                    string FirstName = String.Format("{0}", reader["FirstName"]);
                    string MiddleName = String.Format("{0}", reader["MiddleName"]);
                    string LastName = String.Format("{0}", reader["LastName"]);
                    string Email = String.Format("{0}", reader["Email"]);
                    string Nationality = String.Format("{0}", reader["Nationality"]);
                    string DOB = String.Format("{0}", reader["DOB"]);

                    string Title = String.Format("{0}", reader["Title"]);
                    string Mobile = String.Format("{0}", reader["Mobile"]);
                    string Address = String.Format("{0}", reader["Address"]);
                    string LeaveGroupCode = String.Format("{0}", reader["LeaveGroupCode"]);
                    string DateOfJoining = String.Format("{0}", reader["DateOfJoining"]);                    
                    string picture = String.Format("{0}", reader["Picture"]);
                    string AccessCode = String.Format("{0}", reader["accessCode"]);
                    string AccessLevel = String.Format("{0}", reader["accessLevel"]);

                    dt.Rows.Add(FirstName, MiddleName, LastName, Email, Nationality, DOB, Title, Mobile, Address, LeaveGroupCode, DateOfJoining, picture, AccessCode, AccessLevel);
                }
                else
                {
                    dt.Columns.Add("Error", typeof(string));
                    dt.Rows.Add("No Data Returned");
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getEntitlements(String PersonID, String LeaveGroupCode, String LeaveYear)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT 
	                            empID
	                            ,EssUser
                                ,EPE.[entitlementCode]
	                            ,EPE.[totalEntitlementForPayment]
	                            ,ELPN.Quantity AS daysUsed
	                            ,EPE.[totalEntitlementForPayment] - ELPN.Quantity AS daysAvaliable
                            FROM [dbo].[ESSPersonalEntitlement] AS EPE
                            LEFT JOIN ESSusers AS EU
                            ON EU.PersonID = EPE.empID

                            LEFT JOIN ESSleaverequestPostedNAV AS ELPN
                            ON ELPN.PersonID = EU.PersonID AND ELPN.CauseOfAbsence = EPE.entitlementCode

                            WHERE EU.PersonID = @PersonID";

            cmd.Parameters.AddWithValue("@PersonID", PersonID);

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("entitlementCode", typeof(string));
                //dt.Columns.Add("entitlementDescription", typeof(string));
                //dt.Columns.Add("adjustment", typeof(string));
                //dt.Columns.Add("broughtForward", typeof(string));
                //dt.Columns.Add("carriedForward", typeof(string));
                //dt.Columns.Add("entitlementForPayment", typeof(string));
                dt.Columns.Add("totalEntitlementForPayment", typeof(string));
                dt.Columns.Add("daysUsed", typeof(string));

                dt.Columns.Add("daysAvaliable", typeof(string));

                while (reader.Read())
                {
                    string entitlementCode = String.Format("{0}", reader["entitlementCode"]);
                   // string entitlementDescription = String.Format("{0}", reader["entitlementDescription"]);
                   // string adjustment = String.Format("{0}", reader["adjustment"]);
                   // string broughtForward = String.Format("{0}", reader["broughtForward"]);
                   // string carriedForward = String.Format("{0}", reader["carriedForward"]);
                   // string entitlementForPayment = String.Format("{0}", reader["entitlementForPayment"]);
                    string totalEntitlementForPayment = String.Format("{0}", reader["totalEntitlementForPayment"]);
                    string daysUsed = String.Format("{0}", reader["daysUsed"]);
                    string available = String.Format("{0}", reader["daysAvaliable"]); 

                    //dt.Rows.Add(entitlementCode, entitlementDescription, adjustment, broughtForward, carriedForward, entitlementForPayment, totalEntitlementForPayment, daysUsed);
                    dt.Rows.Add(entitlementCode, totalEntitlementForPayment, daysUsed, available);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getmasterData()
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT 
                                     [id]
                                    ,[dataobj]
                                  ,[dataval]
                              FROM [dbo].[masterdata]";

            
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("id", typeof(string));
                dt.Columns.Add("dataobj", typeof(string));
                dt.Columns.Add("dataval", typeof(string));
                while (reader.Read())
                {
                    string id = String.Format("{0}", reader["id"]);
                    string dataobj = String.Format("{0}", reader["dataobj"]);
                    string dataval = String.Format("{0}", reader["dataval"]);

                    dt.Rows.Add(id, dataobj, dataval);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getSpecificmasterData(String masterDataID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT 
                                     [id]
                                    ,[dataobj]
                                  ,[dataval]
                              FROM [dbo].[masterdata]
                              WHERE id = @masterDataID";

            cmd.Parameters.Add(new SqlParameter("@masterDataID", masterDataID));
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("id", typeof(string));
                dt.Columns.Add("dataobj", typeof(string));
                dt.Columns.Add("dataval", typeof(string));
                while (reader.Read())
                {
                    string id = String.Format("{0}", reader["id"]);
                    string dataobj = String.Format("{0}", reader["dataobj"]);
                    string dataval = String.Format("{0}", reader["dataval"]);

                    dt.Rows.Add(id, dataobj, dataval);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String getLeaveRequestFromNAV(String personID, String COA, String leaveYear)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"
                            SELECT TOP 1 SUM(Quantity) AS Quantity FROM ESSleaverequestPostedNAV
                            WHERE PersonID =  @personID AND [CauseOfAbsence] =  @COA AND leaveYear = @leaveYear
                            ORDER BY Quantity DESC;";

            cmd.Parameters.AddWithValue("@personID", personID);
            cmd.Parameters.AddWithValue("@COA", COA);
            cmd.Parameters.AddWithValue("@leaveYear", leaveYear);

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("Quantity", typeof(string));
                while (reader.Read())
                {
                    string qty = String.Format("{0}", reader["Quantity"]);
                    dt.Rows.Add(qty);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String updateSpecificMasterData(String dataObjID, String dataValue)
        {
            string sqlStatement = @"UPDATE [dbo].[masterdata]
                                    SET dataval = @dataValue
                                    WHERE ID = @dataObjID";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@dataObjID", dataObjID));
                    cmd.Parameters.Add(new SqlParameter("@dataValue", dataValue));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }

        public String validateStartDate(String startDate, String Year, String endDate, String PersonID)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();
            DateTime FDate = DateTime.ParseExact(startDate, "yyyyMMdd", null);
            DateTime TDate = DateTime.ParseExact(endDate, "yyyyMMdd", null);

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"SELECT RequestID,PersonID FROM
	                            (SELECT RequestID,PersonID FROM [dbo].[ESSleaverequest]
	                            WHERE leaveYear = @Year AND PersonID = @PersonID
	                            AND @startDate between FromDate and ToDate AND status != 'REJECTED') AS startDateCheck
                            UNION
	                            (SELECT RequestID,PersonID FROM [dbo].[ESSleaverequest]
	                            WHERE leaveYear = @Year AND PersonID = @PersonID
	                            AND @endDate between FromDate and ToDate AND status != 'REJECTED') 
                            UNION
                            (SELECT RequestID,PersonID FROM [dbo].[ESSleaverequest]
                            WHERE leaveYear = @Year AND PersonID = @PersonID
                            AND FromDate >=  @startDate AND ToDate <=  @endDate AND status != 'REJECTED')";

            cmd.Parameters.AddWithValue("@startDate", FDate);
            cmd.Parameters.AddWithValue("@endDate", TDate);
            cmd.Parameters.AddWithValue("@PersonID", PersonID);
            cmd.Parameters.AddWithValue("@Year", Year);

            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("rowCount", typeof(string));
                int i = 0;
                while (reader.Read())
                {
                    i++;
                }
                dt.Rows.Add(i);
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;            
        }

        public String getHolidays(String year)
        {
            SqlConnection conn = new SqlConnection(connStr);
            SqlCommand cmd = new SqlCommand();
            DataTable dt = new DataTable();

            conn.Open();
            cmd.Connection = conn;
            cmd.CommandText = @"
                            SELECT [holidayName]
                                  ,[holidayDate]
                                  ,[year]
                              FROM [dbo].[holidayTraker]";
                              //WHERE [year] = @leaveYear

            cmd.Parameters.AddWithValue("@leaveYear", year);
            using (SqlDataReader reader = cmd.ExecuteReader())
            {
                dt.Columns.Add("holidayName", typeof(string));
                dt.Columns.Add("holidayDate", typeof(string));
                dt.Columns.Add("year", typeof(string));
                while (reader.Read())
                {
                    string holidayName = String.Format("{0}", reader["holidayName"]);
                    string holidayDate = String.Format("{0}", reader["holidayDate"]);
                    string leaveyear = String.Format("{0}", reader["year"]);

                    dt.Rows.Add(holidayName, holidayDate, leaveyear);
                }
            }
            conn.Close();
            string newdt = DataTableToJSONWithJavaScriptSerializer(dt);
            return newdt;
        }

        public String insertHoliday(int year, String holidayType, String dayNmonth, String holidayName)
        {
            string sqlStatement = @"INSERT INTO [dbo].[holidayTraker]
                                   ([holidayName]
                                   ,[holidayDate]
                                   ,[year])
                             VALUES
                                   (@holidayName
                                    ,@holidayDate
                                   ,@year)";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.Add(new SqlParameter("@holidayName", holidayName));
                    cmd.Parameters.Add(new SqlParameter("@holidayDate", dayNmonth));
                    cmd.Parameters.Add(new SqlParameter("@holidayType", holidayType));
                    cmd.Parameters.Add(new SqlParameter("@year", year));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Inserted";
                        // List<response> res = new List<response>{ new response{status = 0, msg = "Inserted"}};
                        //return serializer.Serialize(res.ToString());

                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
                return resp;
            }
        }

        public String deleteHoliday(String holidayName)
        {
            string sqlStatement = "DELETE FROM holidayTraker WHERE holidayName LIKE @holidayName";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;

                    cmd.Parameters.AddWithValue("@holidayName", holidayName); 

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Deleted";
                       // List<response> res = new List<response>{ new response{status = 0, msg = "Inserted"}};
                        //return serializer.Serialize(res.ToString());

                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }
        public String updatePublicHoliday(String year)
        {
            string sqlStatement = @"UPDATE [essDp].[dbo].[holidayTraker]
                                    SET [year] = @year
                                    WHERE [type] LIKE 'Public Holiday'";

            using (SqlConnection conn = new SqlConnection(connStr))
            {
                using (SqlCommand cmd = new SqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = sqlStatement;
                    cmd.Parameters.Add(new SqlParameter("@year", year));

                    try
                    {
                        conn.Open();
                        cmd.ExecuteNonQuery();
                        resp = "Updated";
                    }
                    catch (SqlException e)
                    {
                        resp = e.ToString();
                    }
                }
            }
            return resp;
        }
    }
}

